<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicketResponse extends Model
{
     protected $fillable = ['ticket_id', 'employee_id', 'message', 'attachements','created_by','updated_by'];
}
