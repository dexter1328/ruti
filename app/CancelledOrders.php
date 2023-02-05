<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelledOrders extends Model
{
     protected $fillable = ['order_id', 'customer_id','vendor_id','store_id','reason', 'status','created_by', 'updated_by'];
}
