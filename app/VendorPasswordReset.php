<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPasswordReset extends Model
{
    protected $fillable = [
        'email', 'token'
    ];
}