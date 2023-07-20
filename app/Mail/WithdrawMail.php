<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WithdrawMail extends Mailable
{
    use Queueable, SerializesModels;
    public $contact_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact_data)
    {
        //
        $this->contact_data = $contact_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from_name = "Nature seller";
        $from_email = "info@naturecheckout.com";
        $subject = "A seller requested to withdraw funds";
        return $this->from($from_email, $from_name)
            ->view('email.withdraw.withdraw_request')
            ->subject($subject);
    }
}
