<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['reference_id', 'title', 'description', 'user_type', 'type'];

    public function userWishlist()
    {
        return $this->hasMany('App\UserWishlist', 'product_id', 'reference_id');
    }
}
