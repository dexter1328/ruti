<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageMeta extends Model
{
    protected $fillable = [
        'meta_key', 'meta_value'
    ];
}
