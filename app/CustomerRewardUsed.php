<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerRewardUsed extends Model
{
    protected $fillable = ['user_id', 'order_id', 'reward_point'];
}
