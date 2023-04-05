<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuppliersOrder extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'supplier_id',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Vendor::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function w2bOrder()
    {
        return $this->belongsTo(W2bOrder::class, 'order_id');
    }
}
