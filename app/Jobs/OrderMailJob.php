<?php

namespace App\Jobs;

use App\Mail\WbOrderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recipient;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipient, $data)
    {
        //

        $this->recipient = $recipient;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $email = new WbOrderMail($this->data);

        Mail::to($this->recipient)->send($email);
    }
}
