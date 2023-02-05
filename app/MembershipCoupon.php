<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembershipCoupon extends Model
{
    protected $fillable = ['vendor_id', 'store_id', 'stripe_coupon_id', 'name', 'discount'];
}
