<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerRewardPoint extends Model
{
     protected $fillable = ['user_id', 'reward_type', 'total_point'];

}
