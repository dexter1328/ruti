<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCoupons extends Model
{
    protected $fillable = ['coupon_code', 'vendor_id', 'store_id','category_id' ,'image', 'type','discount','start_date','end_date','status','description'];
}
