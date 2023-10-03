<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerOrderMail;

class ChangeOrderStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sellerEmail;
    protected $details;

    public function __construct($sellerEmail, $details)
    {
        $this->sellerEmail = $sellerEmail;
        $this->details = $details;
    }

    public function handle()
    {
        $email = new SellerOrderMail($this->details);

        Mail::to($this->sellerEmail)->send($email);
    }
}