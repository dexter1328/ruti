<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class CustomerIncentiveWinner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_incentive:winners';

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
        $limit = 1;
        $date = date('m-Y', strtotime('-1 month'));
        
        $exist_customers = DB::table('customer_incentive_winners')
            ->whereDate('created_at', '>', date("d-m-Y", strtotime('-5 years')))
            ->get()
            ->pluck('user_id')
            ->toArray();
            
        for ($i=1; $i < 4; $i++) { 

            if($i == 1){
                $code = 'bougie';
                $sub_type1 = 'college_scholarship';
                $sub_type2 = 'europe_trip';
                $sub_type3 = 'caribbean_trip';
            }elseif($i == 2){
                $code = 'classic';
                $sub_type1 = 'stay_in_hotel';
                $sub_type2 = 'adventure_park';
                $sub_type3 = 'theme_park';
            }elseif($i == 3){
                $code = 'explorer';
                $sub_type1 = 'gift_card';
                $sub_type2 = 'laptop';
                $sub_type3 = 'tablet';
            }
        
            $inserted_ids = [];
            $subtype1_customers = DB::table('customer_incentive_qualifiers')
                ->where('membership_code', $code)
                ->where('month_year', $date)
                ->whereNotIn('user_id', $exist_customers)
                ->orderBy(DB::raw('RAND()'))
                ->take($limit)
                ->get();

            $subtype1_data = [];
            foreach ($subtype1_customers as $key => $value) {
                $subtype1_data[] = array(
                    'user_id' => $value->user_id, 
                    'month_year' => date('m-Y', strtotime('-1 month')),
                    'membership_code' => $value->membership_code,
                    'type' => $value->type,
                    'sub_type' => $sub_type1,
                    'created_at' => now(),
                    'updated_at' => now()
                );
            }
            if(!empty($subtype1_data)){
                $inserted_ids = $subtype1_customers->pluck('id')->toArray();
                DB::table('customer_incentive_winners')->insert($subtype1_data);
            }

            $subtype2_customers = DB::table('customer_incentive_qualifiers')
                ->where('membership_code', $code)
                ->where('month_year', $date)
                ->whereNotIn('user_id', $exist_customers)
                ->whereNotIn('id', $inserted_ids)
                ->orderBy(DB::raw('RAND()'))
                ->take($limit)
                ->get();

            $subtype2_data = [];
            foreach ($subtype2_customers as $key => $value) {
                $subtype2_data[] = array(
                    'user_id' => $value->user_id, 
                    'month_year' => date('m-Y', strtotime('-1 month')),
                    'membership_code' => $value->membership_code,
                    'type' => $value->type,
                    'sub_type' => $sub_type2,
                    'created_at' => now(),
                    'updated_at' => now()
                );
            }
            if(!empty($subtype2_data)){
                $inserted_ids = array_merge($inserted_ids, $subtype2_customers->pluck('id')->toArray());
                DB::table('customer_incentive_winners')->insert($subtype2_data);
            }

            $subtype3_customers = DB::table('customer_incentive_qualifiers')
                ->where('membership_code', $code)
                ->where('month_year', $date)
                ->whereNotIn('user_id', $exist_customers)
                ->whereNotIn('id', $inserted_ids)
                ->orderBy(DB::raw('RAND()'))
                ->take($limit)
                ->get();

            $subtype3_data = [];
            foreach ($subtype3_customers as $key => $value) {
                $subtype3_data[] = array(
                    'user_id' => $value->user_id, 
                    'month_year' => date('m-Y', strtotime('-1 month')),
                    'membership_code' => $value->membership_code,
                    'type' => $value->type,
                    'sub_type' => $sub_type3,
                    'created_at' => now(),
                    'updated_at' => now()
                );
            }
            if(!empty($subtype3_data)){
                DB::table('customer_incentive_winners')->insert($subtype3_data);
            }
        }
    }
}
