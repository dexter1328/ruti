<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountOfferProduct extends Model
{
   protected $fillable = ['discount_id', 'product_id'];
}
