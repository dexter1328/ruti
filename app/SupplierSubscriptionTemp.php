<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierSubscriptionTemp extends Model
{
   public function membership()
	{
		return $this->belongsTo('App\Membership');
	}
}
