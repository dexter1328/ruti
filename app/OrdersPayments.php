<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersPayments extends Model
{
     protected $fillable = ['date', 'order_id', 'customer_id', 'total_amount', 'coupon_code', 'reward_points', 'net_amount','description','status','created_by','updated_by'];
}
