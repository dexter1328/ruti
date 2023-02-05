<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerWallet extends Model
{
     protected $fillable = ['customer_id', 'amount', 'bank_name', 'creditcard_name', 'debitcard_name'];
}
