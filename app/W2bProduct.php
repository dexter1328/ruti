<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class W2bProduct extends Model
{
    //
    protected $guarded = [];

    protected $primaryKey = 'sku';
    protected $keyType = 'string';

    public $incrementing = false;


    public function ratings()
    {
        return $this->hasMany('App\Rating', 'product_id', 'sku');
    }
    public function vendor()
    {
        return $this->belongsTo('App\Vendor', 'vendor_id','id');
    }
}
