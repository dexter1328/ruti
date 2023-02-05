<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'name', 'email', 'mobile', 'personal_id'
    ];
}
