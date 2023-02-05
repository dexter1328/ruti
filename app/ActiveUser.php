<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveUser extends Model
{
    protected $fillable = ['user_id', 'store_id'];
}
