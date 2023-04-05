<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $user;
    public $old_subscription;
    public $new_subscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $old_subscription, $new_subscription)
    {   
        $this->user = $user;
        $this->old_subscription = $old_subscription;
        $this->new_subscription = $new_subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RUTI Self Checkout Subscription: Thank you for subscribing')->view('/email/customer_subscription_mail')->with([
                'user' => $this->user,
                'old_subscription' => $this->old_subscription,
                'new_subscription' => $this->new_subscription
            ]);

    }
}
