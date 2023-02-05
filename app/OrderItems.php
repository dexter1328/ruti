<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
      protected $fillable = ['order_id', 'product_id','customer_id' ,'product_variant_id', 'measurement', 'quantity', 'price', 'discount','actual_price','barcode_tag','status','return_reason','additional_comment','created_by','updated_by'];
}
