<?php

namespace App\Jobs;

use App\Mail\OrderMailtoSupplier;
use App\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class OrderMailToSupplierJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $details;
    private $suppliersIds;

    /**
     * Create a new job instance.
     */
    public function __construct($details, $suppliersIds)
    {
        $this->details = $details;
        $this->suppliersIds = $suppliersIds;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // $emails = Vendor::where('seller_type', 'supplier')->whereIn('id', $this->suppliersIds)->pluck('email');
        // foreach ($emails as $email) {
        //     Mail::to($email)->send(new OrderMailtoSupplier($this->details));
        // }
    }
}
