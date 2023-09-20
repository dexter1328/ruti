<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminWithdrawMail extends Mailable
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
        // return $this->view('view.name');
        return $this->subject('Nature Checkout')
                    ->view('email.withdraw.withdraw_admin');
    }
}
