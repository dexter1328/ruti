<?php

namespace App\Console\Commands;

use DB;
use Stripe;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerSubscriptionRenewMail;
use App\Mail\CustomerSubscriptionRemiderMail;
use Illuminate\Console\Command;

class RenewCustomerSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_subscription:renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew customer subscription';

    private $stripe_secret;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->stripe_secret = config('services.stripe.secret');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $renew_date = date('Y-m-d');
        
        $users = DB::table('user_subscriptions')
            ->select(
                'user_subscriptions.*',
                'users.email',
                'users.first_name',
                'users.last_name',
                'users.wallet_amount',
                'users.stripe_customer_id',
                'memberships.code',
                'memberships.name AS membership_name',
                'membership_items.billing_period',
                'membership_items.price AS membership_price'
            )
            ->join('users', 'users.id', 'user_subscriptions.user_id')
            ->join('memberships', 'memberships.id', 'user_subscriptions.membership_id')
            ->join('membership_items', 'membership_items.id', 'user_subscriptions.membership_item_id')
            ->whereNotNull('user_subscriptions.membership_item_id')
            ->whereDate('user_subscriptions.membership_end_date', $renew_date)
            ->where('user_subscriptions.status', 'active')
            ->where('user_subscriptions.is_cancelled', 'no')
            ->get();

        foreach ($users as $key => $value) {
            
            $price = $value->price;
            if($value->code == 'bougie' && empty($value->price)) {
                $price = $value->proration_price;
            }

            $renew = 'yes';
            if($price > $value->wallet_amount) {

                Stripe\Stripe::setApiKey($this->stripe_secret);
                try {

                    $charge = Stripe\Charge::create ([
                        "amount" => $price * 100,
                        "currency" => "usd",
                        "customer" => $value->stripe_customer_id,
                        // "source" => $value->card_id,
                        "description" => "Money added in your wallet." 
                    ]);

                    if(empty($value->wallet_amount)){
                        $closing_amount = $price;
                    }else{
                        $closing_amount = $value->wallet_amount + $price;
                    }

                    DB::table('customer_wallets')->insert([
                        'customer_id' => $value->user_id, 
                        'amount' => $price,
                        'closing_amount' => $closing_amount,
                        'type' => 'credit'
                    ]);
                    DB::table('users')->where('id', $value->user_id)->update(['wallet_amount' => $closing_amount, 'updated_at' => now()]);

                } catch(\Stripe\Exception\CardException $e) {
                    $renew = 'no';
                } catch (\Stripe\Exception\RateLimitException $e) {
                    $renew = 'no';
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    $renew = 'no';
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    $renew = 'no';
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    $renew = 'no';
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $renew = 'no';
                } catch (Exception $e) {
                    $renew = 'no';
                }
            }

            if($renew == 'yes') {

                $closing_amount = $value->wallet_amount-$price;
                DB::table('customer_wallets')->insert([
                    'customer_id' => $value->user_id, 
                    'amount' => $price,
                    'closing_amount' => $closing_amount,
                    'type' => 'subscription_charge'
                ]);
                DB::table('users')->where('id', $value->user_id)->update(['wallet_amount' => $closing_amount, 'updated_at' => now()]);

                $membership_start_date = $value->membership_end_date;
                $membership_end_date = date('Y-m-d H:i:s', strtotime('+1 '.$value->renew_period, strtotime($membership_start_date)));
                $update_data = array(
                    'membership_start_date' => $membership_start_date,
                    'membership_end_date' => $membership_end_date,
                    'updated_at' => now()
                );
                if($value->code == 'bougie' && empty($value->price)) {
                    $update_data['price'] = $price;
                    $update_data['proration_price'] = NULL;
                }

                DB::table('user_subscriptions')->where('id', $value->id)->update($update_data);

                Mail::to($value->email)->send(new CustomerSubscriptionRenewMail($value));
            }
        }  
    }
}
