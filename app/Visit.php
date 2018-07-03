<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public $timestamps = false;
	
    protected $fillable = [
        'post_id', 'user_id', 'user_name'
    ];
}
