<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembershipItem extends Model
{
    protected $fillable = ['membership_id', 'billing_period', 'price'];

    public function membership()
    {
        return $this->belongsTo('App\Membership');
    }
}
