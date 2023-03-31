<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMailtoSupplier extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $body;

    /**
     * Create a new message instance.
     */
    public function __construct($details)
    {
        $this->title = $details['title'];
        $this->body = $details['body'];
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('email.new_order_mail_to_supplier', [
                'body' => $this->body
            ]);
    }
}
