<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class CustomerDeactivateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_deactivate:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer  Deactivate';

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
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');

        $setting = Setting::where('key', 'cancel_return_order_limit')->first();
        if(!empty($setting)){

            $users = DB::table('users As u')
                ->select(
                    'u.id',
                    DB::raw(
                        "(SELECT COUNT(DISTINCT o.id) 
                            FROM orders AS o
                            WHERE u.id = o.customer_id
                            AND o.order_status = 'cancelled'
                            AND date(o.updated_at) BETWEEN '".$start_date."' AND '".$end_date."'
                        ) +
                        (SELECT COUNT(DISTINCT i.id) 
                            FROM order_items AS i
                            WHERE u.id = i.customer_id
                            AND i.status = 'return'
                            AND date(o.updated_at) BETWEEN '".$start_date."' AND '".$end_date."'
                        ) AS total_canel_return"
                    ),
                )
                ->having('total_canel_return', '>=', $setting->value)
                ->get();

            if($users-isNotEmpty()){
                foreach ($users as $key => $user) {
                    
                    DB::table('users')->where('id', $user->id)->update(['status' => 'deactive']);
                }
            }
        }  
    }
}
