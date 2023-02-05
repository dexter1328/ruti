<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNewsletter extends Model
{
     protected $fillable = ['user_id', 'newsletter_id','type','send_by'];
}
