<?php

namespace App;

use App\Scopes\SupplierScopeTrait;
use Illuminate\Database\Eloquent\Model;

class VendorCoupons extends Model
{
    use SupplierScopeTrait;

    protected $fillable = [
        'coupon_code',
        'vendor_id',
        'store_id',
        'category_id',
        'image',
        'type',
        'discount',
        'start_date',
        'end_date',
        'status',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();

//        self::sellerTypeGlobalScope('vendor_coupons');
    }
}
