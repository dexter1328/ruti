<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreSubscription extends Model
{
	protected $fillable = ['vendor_id', 'store_id', 'card_id', 'subscription_id', 'subscription_item_id', 'membership_id', 'membership_code', 'membership_item_id', 'membership_coupon_id', 'extra_license', 'start_date', 'end_date', 'is_cancelled', 'status'];

	public function membership()
	{
		return $this->belongsTo('App\Membership');
	}

	public function membershipItem()
	{
		return $this->belongsTo('App\MembershipItem');
	}
}
