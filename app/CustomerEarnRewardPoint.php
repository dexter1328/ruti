<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerEarnRewardPoint extends Model
{
    protected $fillable = ['user_id', 'reward_type', 'reward_point'];
}
