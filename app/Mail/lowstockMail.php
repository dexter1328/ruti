<?php

namespace App\Mail;

use App\User;
use App\Bookings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowstockMail extends Mailable
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
    public function __construct($product_id_email)
    {
        $this->product_id_email = $product_id_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // print_r($user);die();

        return $this->subject('Nature Checkout Order: Lowstock Mail')->view('/admin/products/lowstock_mail')->with([
                'product_id_email' => $this->product_id_email
            ]);

    }
}
