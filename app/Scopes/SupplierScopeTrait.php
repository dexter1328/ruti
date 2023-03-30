<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait SupplierScopeTrait
{
    public static function sellerTypeGlobalScope()
    {
        $sellerType = new SellerTypeScope();
        $sellerType->setTableName((new self)->getTable());
        static::addGlobalScope($sellerType);
    }

    public function scopeSupplier(Builder $builder){
        $sellerTypeScope = new SellerTypeScope(SUPPLIER);
        $sellerTypeScope->setTableName($this->getTable());
        $builder->withoutGlobalScope(SellerTypeScope::class)
            ->withGlobalScope(SUPPLIER, $sellerTypeScope);
    }

    public function scopeVendor(Builder $builder){
        $sellerTypeScope = new SellerTypeScope(VENDOR);
        $sellerTypeScope->setTableName($this->getTable());
        $builder->withoutGlobalScope(SellerTypeScope::class)
            ->withGlobalScope(SUPPLIER, new SellerTypeScope(VENDOR));
    }
}
