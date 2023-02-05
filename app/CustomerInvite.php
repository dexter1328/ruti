<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerInvite extends Model
{
     protected $fillable = ['customer_id','invite_by_id' ,'date', 'type', 'email', 'mobile_no','source', 'status','created_by', 'updated_by'];
}
