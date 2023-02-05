<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerSubscriptionCancelMail;
use Illuminate\Console\Command;

class CancelCustomerSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_subscription:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel customer subscription';

    private $stripe_secret;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expired_date = date('Y-m-d');
        $users = DB::table('user_subscriptions')
            ->select(
                'users.email',
                'users.first_name',
                'users.last_name',
                'memberships.name AS membership_name',
                'membership_items.billing_period',
            )
            ->join('users', 'users.id', 'user_subscriptions.user_id')
            ->join('memberships', 'memberships.id', 'user_subscriptions.membership_id')
            ->join('membership_items', 'membership_items.id', 'user_subscriptions.membership_item_id')
            ->whereNotNull('membership_item_id')
            ->whereDate('user_subscriptions.membership_end_date', '<' , $expired_date)
            ->get();

        foreach ($users as $key => $value) {

            $update_data = array(
                'membership_id' => 1,
                'membership_item_id' => NULL,
                'membership_start_date' => NULL,
                'membership_end_date' => NULL,
                'price' => NULL,
                'proration_price' => NULL,
                'renew_period' => NULL,
                'is_cancelled' => 'no',
                'updated_at' => now()
            );
            DB::table('user_subscriptions')->where('id', $value->id)->update($update_data);

            Mail::to($value->email)->send(new CustomerSubscriptionCancelMail($value));
        }  
    }
}
