<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class W2bCategory extends Model
{
    protected $guarded = [];


    public function parent()
    {
        return $this->belongsTo('App\W2bCategory', 'parent_id');
    }
    public function childrens()
    {
        return $this->hasMany('App\W2bCategory', 'parent_id');
    }

    public function source()
    {
        return $this->belongsTo(W2bCategory::class, 'source_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Vendor::class, 'supplier_id');
    }

    // public function products()
    // {
    //     return $this->hasMany('App\Product');
    // }
    //  public function getAddedbyAttribute()
    //  {
    //      return $this->admin->full_name;
    //  }
    public function getParentnameAttribute()
    {
        return $this->parent_id ? $this->parent->name : 'No Parent';
    }
}
