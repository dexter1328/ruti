<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklySuggestedStoreMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $suggested_stores;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($suggested_stores)
    {
        $this->suggested_stores = $suggested_stores;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RUTI Self Checkout: Weekly Registered Retailers')->view('email/admin/weekly_suggested_stores')->with([
                'suggested_stores' => $this->suggested_stores,
            ]);
    }
}
