<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
   protected $fillable = ['name','country_id','created_at','updated_at'];
}
