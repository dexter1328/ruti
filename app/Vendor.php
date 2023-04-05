<?php

namespace App;

use App\Notifications\VendorResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','membership_id', 'registered_date', 'expired_date', 'address', 'city','state','country','lat','long','pincode','phone_code','phone_number','mobile_number','website_link','status','parent_id','admin_commision','verification','business_name','tax_id','image'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new VendorResetPassword($token));
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAssignStoreName($childVendorID)
    {
        $assignStore =\DB::table('stores_vendors')
            ->select('vendor_stores.name')
            ->join('vendor_stores', 'vendor_stores.id', 'stores_vendors.store_id')
            ->where('stores_vendors.vendor_id', $childVendorID)
            ->first();
        if(!empty($assignStore)) {
            $store_name = $assignStore->name;
        }else {
            $store_name = '';
        }
        return $store_name;
    }

    public function getParentName($parentID)
    {
         $parent =\DB::table('vendors')
            ->select('vendors.name')
            ->where('vendors.id', $parentID)
            ->first();
        if(!empty($parent)) {
            $parent_name = $parent->name;
        }else {
            $parent_name = '';
        }
        return $parent_name;
    }

    public function vendorRole()
    {
        return $this->belongsTo('App\VendorRoles', 'role_id');
    }
}
