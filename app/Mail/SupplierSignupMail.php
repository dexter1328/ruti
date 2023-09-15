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
    public $email;
    public $name;
    public $id;
    public $address;
    public $country;
    public $state;
    public $city;
    public $pincode;
    public $phone_number;
    public $mobile_number;

    /**
     * Create a new message instance.
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
        return $this->subject('New Supplier Signup')->view('admin.suppliers.supplier_signup_mail')->with([
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
