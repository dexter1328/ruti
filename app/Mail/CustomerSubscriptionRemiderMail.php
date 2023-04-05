<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerSubscriptionRemiderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $user;
    public $days;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $days)
    {
        $this->user = $user;
        $this->days = $days;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nature Checkout Subscription: Insufficient funds for auto renewal plan')->view('/email/customer_subscription_reminder_mail')->with([
                'user' => $this->user,
                'days' => $this->days
            ]);

    }
}
