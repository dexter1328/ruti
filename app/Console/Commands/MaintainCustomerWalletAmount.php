<?php

namespace App\Console\Commands;

use DB;
use Stripe;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\CustomerSubscriptionRenewMail;
use Illuminate\Console\Command;

class MaintainCustomerWalletAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_wallet:maintain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Maintain customer wallet low balance amount';

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
        $min_amount = 25;
        $users = DB::table('users')
            ->whereNotNull('stripe_customer_id')
            ->where('wallet_amount', '<', $min_amount)
            ->get();

        foreach ($users as $key => $value) {
            
            $price = $min_amount - $value->wallet_amount;

            Stripe\Stripe::setApiKey($this->stripe_secret);
            try {

                $charge = Stripe\Charge::create ([
                    "amount" => $price * 100,
                    "currency" => "usd",
                    "customer" => $value->stripe_customer_id,
                    // "source" => $value->card_id,
                    "description" => "Money automatically added in your wallet due to low balance." 
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
                
            } catch (\Stripe\Exception\RateLimitException $e) {
                
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                
            } catch (\Stripe\Exception\AuthenticationException $e) {
                
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                
            } catch (\Stripe\Exception\ApiErrorException $e) {
                
            } catch (Exception $e) {
                
            }
        } 
    }
}
