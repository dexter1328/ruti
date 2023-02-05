<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
	protected $fillable = ['user_id', 'membership_id', 'membership_item_id', 'membership_start_date', 'membership_end_date', 'status'];

    protected $casts = ['is_used_bougie' => 'integer'];

	public function user()
    {
        return $this->belongsTo('App\User');
    }

	public function membership()
    {
        return $this->belongsTo('App\Membership');
    }

    public function membershipItem()
    {
        return $this->belongsTo('App\MembershipItem');
    }
}
