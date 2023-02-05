<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Orders;
use App\OrderItems;
use App\ArchiveCancelOrder;
use App\ArchiveReturnOrder;
use Carbon\Carbon;

class CancelArchiveCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel_archive:cron';

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
        $orders = Orders::where('order_status','cancelled')->whereRaw('DATE(updated_at) < "'.date('Y-m-d', strtotime(' - 30 days')).'"')->get();

        if($orders->isNotEmpty()){

            $data = [];
            foreach ($orders as $key => $value) {
                $data[] = array('customer_id' => $value->customer_id,
                    'vendor_id' => $value->vendor_id,
                    'store_id' => $value->store_id,
                    'order_no' => $value->order_no,
                    'type' => $value->type,
                    'pickup_time' => $value->pickup_time,
                    'pickup_date' => $value->pickup_date,
                    'order_status' => $value->order_status,
                    'total_price' => $value->total_price,
                    'promo_code' => $value->promo_code,
                    'item_total' => $value->item_total,
                    'coupon_id' => $value->coupon_id,
                    'tax' => $value->tax,
                    'cancel_reason' => $value->cancel_reason,
                    'additional_comment' => $value->additional_comment,
                    'completed_date' => $value->completed_date,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now());

            }
            ArchiveCancelOrder::insert($data);
            
            $orders = Orders::where('order_status','cancelled')->whereRaw('DATE(updated_at) < "'.date('Y-m-d', strtotime(' - 30 days')).'"')->delete(); 
            // \Log::info('cancel successfully');
            // $this->info('Archive:Cron Cummand Run successfully!');
        }
    }
}
