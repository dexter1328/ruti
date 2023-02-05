<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminRolePermission extends Model
{
    protected $fillable = ['role_id', 'module_name'];
}
