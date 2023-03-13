<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $user;
    public $card;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $card)
    {
        $this->user = $user;
        $this->card = $card;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nature Checkout Subscription: Payment Failed')->view('/email/invoice_failed_mail')->with([
                'user' => $this->user,
                'card' => $this->card
            ]);

    }
}
