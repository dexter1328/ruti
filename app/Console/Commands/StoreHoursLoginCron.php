<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Vendor;
use App\VendorRoles;
use App\StoresVendor;
use App\VendorStoreHours;

class StoreHoursLoginCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store_hours_login:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $store_vendor = StoresVendor::where('vendor_id',$user->id)->first();
        if(!empty($store_vendor))
        {
            date('w'); //gets day of week as number(0=sunday,1=monday...,6=sat)

            if(date('w') == 1){
                $day = 'monday';
            }else if(date('w') == 2){
                $day = 'tuesday';
            }else if(date('w') == 3){
                $day = 'wednesday';
            }else if(date('w') == 4){
                $day = 'thursday';
            }else if(date('w') == 5){
                $day = 'friday';
            }else if(date('w') == 6){
                $day = 'saturday';
            }else if(date('w') == 7){
                $day = 'sunday';
            }
        
            $current_date = date("H:i");

            $vendor_store_hours = VendorStoreHours::where('week_day',$day)
                        ->where('store_id',$store_vendor->store_id)
                        ->whereRaw('TIME(daystart_time) <= "'.$current_date.'"')
                        ->whereRaw('TIME(dayend_time) >= "'.$current_date.'"')
                        ->first();

            if(!empty($vendor_store_hours))
            {
                //notofication suuccess login
            }else{
                // login in store time
            }
        }else{
            // you can not assign the store
        }
    }
}
