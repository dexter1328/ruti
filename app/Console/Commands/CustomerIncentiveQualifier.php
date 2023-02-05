<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class CustomerIncentiveQualifier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_incentive:qualifiers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer Incentive Qualifiers';

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
        $date = date('m-Y', strtotime('-1 month'));
        $date_arr = explode('-', $date);
        $month = $date_arr[0];
        $year = $date_arr[1];

        for ($i=1; $i < 4; $i++) { 

            if($i == 1){
                $code = 'bougie';
                $price = 150;
            }elseif($i == 2){
                $code = 'classic';
                $price = 100;
            }elseif($i == 3){
                $code = 'explorer';
                $price = 100;
            }
        
            $tier_customers = DB::table('users')
                ->select(
                    'users.*',
                    'memberships.code',
                    'memberships.name',
                    DB::raw('COUNT(orders.id) as order_count')
                )
                ->join('user_subscriptions', 'user_subscriptions.user_id', 'users.id')
                ->join('memberships', 'memberships.id', 'user_subscriptions.membership_id')
                ->join('orders', 'orders.customer_id', 'users.id')
                ->where('users.is_join', 1)
                ->where('memberships.code', $code)
                ->where('orders.total_price', '>=', $price)
                ->where('orders.order_status', 'completed')
                ->whereMonth('orders.created_at', $month)
                ->whereYear('orders.created_at', $year)
                ->having('order_count', '>=', 2)
                ->get();


            $tier_data = [];
            foreach ($tier_customers as $key => $value) {
                $tier_data[] = array(
                    'user_id' => $value->id, 
                    'month_year' => date('m-Y', strtotime('-1 month')),
                    'membership_code' => $code,
                    'type' => 'tier_'.$i,
                    'created_at' => now(),
                    'updated_at' => now()
                );
            }
            if(!empty($tier_data)){
                DB::table('customer_incentive_qualifiers')->insert($tier_data);
            }
        }
    }
}
