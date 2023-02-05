<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerWalletInward extends Model
{
     protected $fillable = ['customer_id', 'inward_date', 'amount', 'bank_name', 'creditcard_name', 'debitcard_name', 'status','created_by','updated_by'];
}
