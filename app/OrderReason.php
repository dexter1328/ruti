<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderReason extends Model
{
    protected $fillable = ['reason', 'type'];
}
