<?php

namespace App\Mail;

use App\User;
use App\Bookings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReturnVendorMail extends Mailable
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
    public function __construct($order_items)
    {
        $this->order_items = $order_items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // print_r($user);die();

        return $this->subject('Nature Checkout Order: Return Request')->view('/admin/orders_returns/order_return_mail')->with([
                'order_items' => $this->order_items
            ]);

    }
}
