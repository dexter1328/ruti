<?php

namespace App\Mail;

use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorSignupMail extends Mailable
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
    public function __construct($email,$name,$id,$address,$country,$state,$city,$pincode,$phone_number,$mobile_number)
    {
        $this->email = $email;
        $this->name = $name;
        $this->id = $id;
        $this->address = $address;
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
        $this->pincode = $pincode;
        $this->phone_number = $phone_number;
        $this->mobile_number  = $mobile_number;
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

        return $this->subject('New Vendor Signup')->view('/admin/vendors/vendor_signup_mail')->with([
                'email' => $this->email,
                'name' => $this->name,
                'id' => $this->id,
                'address' => $this->address,
                'country' =>$this->country,
                'state'  =>$this->state,
                'city' =>$this->city,
                'pincode' =>$this->pincode,
                'phone_number' => $this->phone_number,
                'mobile_number' => $this->mobile_number
            ]);
    }
}
