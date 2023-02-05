<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardPoint extends Model
{
    protected $fillable = ['reward_type', 'reward_points', 'reward_point_exchange_rate', 'status', 'end_date'];
}
