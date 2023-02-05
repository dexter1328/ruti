<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorStore extends Model
{
    protected $fillable = ['vendor_id', 'name', 'image', 'address1','address2', 'city','state','country','lat','long','pincode','phone_code','branch_admin','phone_number','mobile_number','email','password','website_link','open_status','status','return_policy','admin_commision'];

    /**
     * Get the author that wrote the book.
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}
