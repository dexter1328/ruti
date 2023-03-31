<?php

namespace App\Mail;

use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorVerificationMail extends Mailable
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
    public function __construct($email,$name)
    {
        $this->email = $email;
        $this->name = $name;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // print_r($user);die();

        // return $this->view('/admin/service_provider/background_check')->with([
        //         'id' => $this->id
        //     ]);
        return $this->subject('RUTI Self Checkout: Account Verified')->view('/admin/vendors/vendor_verification_mail')->with([
                'email' => $this->email,
                'name' => $this->name
            ]);
    }
}
