<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderReturndetails extends Model
{
      protected $fillable = ['return_id', 'order_id', 'customer_id', 'vendor_id', 'store_id', 'product_id', 'product_variant_id','measurement','quantity','price','discount','barcode_tag','created_by','updated_by'];
}
