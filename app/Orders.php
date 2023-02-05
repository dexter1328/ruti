<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['pickup_date', 'pickup_time','special_instruction' ,'customer_id', 'vendor_id', 'store_id', 'type','order_no' ,'total_price','order_status','is_verified','cancel_reason','additional_comment','completed_date','created_by','updated_by'];
}
