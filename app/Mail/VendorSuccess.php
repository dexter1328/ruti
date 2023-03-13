<?php

namespace App\Mail;

use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorSuccess extends Mailable
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
    public function __construct($email,$password,$vendor_name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->vendor_name = $vendor_name;

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
        return $this->subject('Nature Checkout: Welcome to Nature Checkout')->view('/admin/vendors/vendor_success')->with([
                'email' => $this->email,
                'password' => $this->password,
                'name' => $this->vendor_name
            ]);
    }
}
