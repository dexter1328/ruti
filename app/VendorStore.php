<?php

namespace App;

use App\Scopes\SellerTypeScope;
use App\Scopes\SupplierScopeTrait;
use Illuminate\Database\Eloquent\Model;

class VendorStore extends Model
{
    use SupplierScopeTrait;

    protected $fillable = [
        'vendor_id',
        'name',
        'image',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'lat',
        'long',
        'pincode',
        'phone_code',
        'branch_admin',
        'phone_number',
        'mobile_number',
        'email',
        'password',
        'website_link',
        'open_status',
        'status',
        'return_policy',
        'admin_commision',
        'seller_type'
    ];

    /**
     * Get the author that wrote the book.
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

//        static::sellerTypeGlobalScope('vendor_stores');
    }
}
