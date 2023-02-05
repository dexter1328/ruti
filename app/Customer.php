<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected $fillable = ['wallet_id', 'first_name', 'last_name', 'email', 'address', 'city', 'state','country','lat','long','pincode','phone_code','dob','anniversary_date','mobile','receive_newsletter','terms_conditions','status'];
}
