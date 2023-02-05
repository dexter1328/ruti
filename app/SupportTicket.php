<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
     protected $fillable = ['customer_id', 'vendor_id', 'store_id', 'subject', 'message', 'status', 'attachements','created_by','updated_by'];
}
