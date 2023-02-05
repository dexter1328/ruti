<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPayment extends Model
{
    protected $fillable = ['vendor_id', 'store_id', 'order_id', 'amount', 'transaction_id', 'paid_date', 'status'];
}
