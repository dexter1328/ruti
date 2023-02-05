<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorRoles extends Model
{
    protected $fillable = ['role_name', 'status', 'created_by', 'updated_by'];
}
