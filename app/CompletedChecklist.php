<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompletedChecklist extends Model
{
    protected $fillable = ['user_id', 'checklist_code'];
}
