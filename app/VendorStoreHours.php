<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorStoreHours extends Model
{
     protected $fillable = ['store_id', 'week_day', 'daystart_time', 'dayend_time', 'evening_start_time','evening_end_time','status','created_by', 'updated_by'];
}
