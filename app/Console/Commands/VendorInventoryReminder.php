<?php

namespace App\Console\Commands;

use DB;
use App\Traits\AppNotification;
use App\Mail\VendorInventoryReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class VendorInventoryReminder extends Command
{
    use AppNotification;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor_inventory:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vendor Inventory Reminder';

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
        $day = date('l');
        $time = date('H:i');
        $date = date('Y-m-d', strtotime('-7 days'));
        $users = DB::table('vendors')
            ->select(
                'vendors.id',
                'vendors.name',
                'vendors.email',
                'stores_vendors.store_id',
                'vendor_stores.name as store_name'
            )
            ->join('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
            ->join('stores_vendors', 'stores_vendors.vendor_id', 'vendors.id')
            ->join('vendor_stores', 'vendor_stores.id', 'stores_vendors.store_id')
            ->join('vendor_settings as setting_day', 'setting_day.vendor_id', 'vendors.parent_id')
            ->join('vendor_settings as setting_time', 'setting_time.vendor_id', 'vendors.parent_id')
            ->join('products', 'products.store_id', 'stores_vendors.store_id')
            ->where(function ($query) {
                $query->where('vendor_roles.slug', 'store-manager')
                      ->orWhere('vendor_roles.slug', 'store-supervisor');
            })
            ->where('setting_day.key', 'inventory_update_reminder_day')
            ->where('setting_day.value', $day)
            /*->where('setting_time.key', 'inventory_update_reminder_time')
            ->where('setting_time.value', $time)*/
            ->whereDate('products.updated_at', '<', $date)
            ->groupBy('stores_vendors.store_id')
            ->get();

        // \Log::info($users);

        foreach ($users as $key => $value) {

            Mail::to($value->email)->send(new VendorInventoryReminderMail($value));

            $id = null;
            $type = 'inventory_update_reminder';
            $title = 'Inventory Update Reminder';
            $message = 'It is time to update inventory. Please follow the steps to complete the process.';
            $devices = DB::table('user_devices')->where('user_id', $value->id)->where('user_type','vendor')->get();
            $this->sendVendorNotification($title, $message, $devices, $type, $id);
        }
    }
}
