<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BuyerReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $customer;
    public $supplier;
    public $suggested_products;

    public function __construct($customer, $supplier, $suggested_products)
    {
        $this->customer = $customer;
        $this->supplier = $supplier;
        $this->suggested_products = $suggested_products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reminder to purchase ')->view('supplier.customers.reminderMail')->with([
            'customer' => $this->customer,
            'supplier' => $this->supplier,
            'suggested_products' => $this->suggested_products
        ]);
    }
}
