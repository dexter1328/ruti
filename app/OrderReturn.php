<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
      protected $fillable = ['date', 'order_id','item_id' ,'customer_id', 'vendor_id', 'store_id','created_by','updated_by'];
}
