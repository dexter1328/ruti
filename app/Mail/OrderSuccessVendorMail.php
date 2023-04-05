<?php

namespace App\Mail;

use App\User;
use App\Bookings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSuccessVendorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orders)
    {   
        $this->orders = $orders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // print_r($user);die();

        return $this->subject('RUTI Self Checkout Order: Order Success')->view('/admin/orders/order_success_mail')->with([
                'orders' => $this->orders
            ]);

    }
}
