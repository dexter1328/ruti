<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    protected $fillable = ['stripe_customer_id', 'stripe_subscription_id', 'stripe_price_id', 'plan_amount', 'plan_interval', 'plan_interval_count', 'plan_period_start', 'plan_period_end', 'status', 'user_type', 'action'];
}
