<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyRetailerRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $users;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RUTI Self Checkout: Weekly Registered Retailers')->view('email/admin/weekly_register_retailer')->with([
                'users' => $this->users,
            ]);
    }
}
