<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SellerTypeScope implements Scope
{
    private string $sellerType = VENDOR;
    private string $tableName = '';

    public function __construct(string $sellerType = null)
    {
        $this->sellerType = $sellerType ?? $this->sellerType;
    }

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder  $builder
     * @param  Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $column = "seller_type";
        if (!empty($this->tableName)) {
            $column = "$this->tableName.seller_type";
        }
        $builder->where($column, '=', $this->sellerType);
    }
}
