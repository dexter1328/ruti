<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariants extends Model
{
     protected $fillable = ['product_id', 'attribute_id', 'sku_uniquecode', 'barcode', 'quantity', 'price', 'discount','manage_stock','lowstock_threshold','created_by','updated_by'];
}
