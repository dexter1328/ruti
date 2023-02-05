<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = ['code', 'name', 'type'];

    protected $casts = [
        'description' => 'object'
    ];

    public function membershipItems()
    {
        return $this->hasMany('App\MembershipItem');
    }

    public function monthMembershipItem()
    {
        return $this->hasOne('App\MembershipItem')->where('billing_period', 'month')->whereNull('license');
    }

    public function monthMembershipItemOneLicense()
    {
        return $this->hasOne('App\MembershipItem')->where('billing_period', 'month')->where('license', 1);
    }

    public function monthMembershipItemTwoLicense()
    {
        return $this->hasOne('App\MembershipItem')->where('billing_period', 'month')->where('license', 2);
    }

    public function yearMembershipItem()
    {
        return $this->hasOne('App\MembershipItem')->where('billing_period', 'year')->whereNull('license');
    }

    public function yearMembershipItemOneLicense()
    {
        return $this->hasOne('App\MembershipItem')->where('billing_period', 'year')->where('license', 1);
    }

    public function yearMembershipItemTwoLicense()
    {
        return $this->hasOne('App\MembershipItem')->where('billing_period', 'year')->where('license', 2);
    }

    public function discountMembershipItem()
    {
        return $this->hasOne('App\MembershipItem')->whereNull('billing_period');
    }
}