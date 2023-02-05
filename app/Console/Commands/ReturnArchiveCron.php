<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Orders;
use App\OrderItems;
use App\ArchiveCancelOrder;
use App\ArchiveReturnOrder;
use Carbon\Carbon;

class ReturnArchiveCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'return_archive:cron';

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
        $order_items = OrderItems::where('status','return')->whereRaw('DATE(updated_at) < "'.date('Y-m-d', strtotime(' - 30 days')).'"')->get();
        
        if($orders->isNotEmpty()){

            $data = [];
            foreach ($order_items as $key => $value) {
                $data[] = array('order_id' => $value->order_id,
                    'product_variant_id' => $value->product_variant_id,
                    'customer_id' => $value->customer_id,
                    'quantity' => $value->quantity,
                    'price' => $value->price,
                    'actual_price' => $value->actual_price,
                    'discount' => $value->discount,
                    'status' => $value->status,
                    'return_reason' => $value->return_reason,
                    'additional_Comment' => $value->additional_Comment,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now());

            }
            ArchiveReturnOrder::insert($data);
            
            $order_items = OrderItems::where('status','return')->whereRaw('DATE(updated_at) < "'.date('Y-m-d', strtotime(' - 30 days')).'"')->delete(); 
            // \Log::info('return successfully');
            // $this->info('Archive:Cron Cummand Run successfully!');
        }
    }
}
