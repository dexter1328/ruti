<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminOtp extends Model
{
    protected $fillable = [
        'email', 'token', 'otp'
    ];
}
