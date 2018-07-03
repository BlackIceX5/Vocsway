<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    public $timestamps = false;
	
    protected $fillable = [
        'post_id', 'car_id', 'user_id', 'path'
    ];
}
