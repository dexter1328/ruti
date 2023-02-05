<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsOutward extends Model
{
      protected $fillable = ['date', 'vendor_id', 'store_id', 'customer_id', 'order_id', 'product_variant_id', 'product_id','quantity','status','created_by','updated_by'];
}
