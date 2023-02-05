<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerWalletOutward extends Model
{
     protected $fillable = ['customer_id', 'vendor_id', 'store_id', 'order_id', 'outward_date', 'amount', 'status','created_by','updated_by'];
}
