<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class W2bOrder extends Model
{
    protected $guarded = [];
    protected $hidden = ['status'];

    public function products(): HasMany
    {
        return $this->hasMany(OrderedProduct::class, 'order_id', 'order_id');
    }

    public function supplierOrders(): HasMany
    {
        return $this->hasMany(SuppliersOrder::class, 'order_id', 'order_id');
    }
}
