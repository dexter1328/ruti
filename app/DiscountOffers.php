<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountOffers extends Model
{
    protected $fillable = ['vendor_id', 'store_id', 'category_id','title','description','discount'];
}
