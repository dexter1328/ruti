<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class W2bProduct extends Model
{
    //
    protected $guarded = [];


    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }
}
