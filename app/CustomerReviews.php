<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerReviews extends Model
{
      protected $fillable = ['date', 'customer_id', 'vendor_id', 'store_id', 'order_id', 'review', 'status'];
}
