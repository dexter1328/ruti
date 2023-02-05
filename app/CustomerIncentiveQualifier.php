<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerIncentiveQualifier extends Model
{
    protected $fillable = ['user_id', 'month_year', 'membership_code', 'type', 'sub_type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
