<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorRolePermission extends Model
{
     protected $fillable = ['role_id', 'module_name'];
}
