<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    
    public function invoiceItems()
    {
        return $this->hasMany('App\InvoiceItem');
    }

    public function membershipCoupon()
    {
        return $this->belongsTo('App\MembershipCoupon');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }

    public function vendorStore()
    {
        return $this->belongsTo('App\VendorStore', 'store_id');
    }
}
