<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerFeedback extends Model
{
     protected $fillable = ['date', 'customer_id', 'vendor_id', 'store_id', 'message','status'];
}
