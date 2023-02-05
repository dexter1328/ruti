<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['menu_id', 'title','slug','content', 'image', 'status', 'created_by', 'updated_by','created_at','updated_at'];
}
