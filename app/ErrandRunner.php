<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrandRunner extends Model
{
    protected $fillable = ['customer_id', 'status'];
}
