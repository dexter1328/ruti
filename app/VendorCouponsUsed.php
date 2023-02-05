<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCouponsUsed extends Model
{
    protected $fillable = ['coupon_id', 'user_id','order_id','date_time','created_by', 'updated_by'];
}
