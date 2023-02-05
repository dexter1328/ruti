<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorConfiguration extends Model
{
     protected $fillable = ['vendor_id', 'payment_gateway', 'client_id', 'client_secret', 'access_token','created_by', 'updated_by'];

 }
