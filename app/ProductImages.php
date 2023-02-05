<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
      protected $fillable = ['vendor_id', 'store_id', 'product_id', 'image'];
}
