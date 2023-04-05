<?php

namespace App\Mail;

use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierSignupMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     */
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->emailData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Supplier Signup')->view('admin.suppliers.supplier_signup_mail', $this->emailData);
    }
}
