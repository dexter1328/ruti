<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Vendor;
use App\VendorSetting;
use App\User;
use App\Mail\BuyerReminderMail;
use Illuminate\Support\Facades\Mail;
use App\SuppliersOrder;
use App\W2bProduct;

class BuyerReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_buyer_reminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder to buyer';

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
     */
    public function handle()
    {

        $day = date('l');
        $time = date('H:i');

        $checkDay = VendorSetting::where('key', 'remind_day_to_buyer')->where('seller_type', 'supplier')->get();
        $checkTime = VendorSetting::where('key', 'remind_time_to_buyer')->where('seller_type', 'supplier')->get();

        foreach ($checkDay as $day_in_data) {
            foreach ($checkTime as $time_in_data) {
                if ($day_in_data->value == $day && $time_in_data->value == $time) {

                    $userIds = SuppliersOrder::select('user_id')->where('supplier_id', $time_in_data->vendor_id)->pluck('user_id');
                    $customers = User::whereIn('id', $userIds)->get();

                    $supplier = Vendor::where('id', $time_in_data->vendor_id)->first();

                    $suggested_products = W2bProduct::inRandomOrder()->where('supplier_id', $time_in_data->vendor_id)->take(3)->get();

                    foreach ($customers as $key => $customer) {

                        Mail::to($customer->email)->send(new BuyerReminderMail($customer, $supplier, $suggested_products));

                    }
                }
            }
        }


        \Log::info("Cron is working fine buy azhar!");


    }
}
