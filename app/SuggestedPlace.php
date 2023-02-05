<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuggestedPlace extends Model
{
   protected $fillable = ['user_id', 'place','description'];
}
