<?php

namespace App\Mail;

use App\User;
use App\Bookings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorInventoryReminderMail extends Mailable
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
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // print_r($user);die();

        return $this->subject('Nature Checkout: Inventory Update Reminder')->view('/email/vendor/inventory_update_mail')->with([
                'user' => $this->user
            ]);

    }
}
