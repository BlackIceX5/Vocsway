<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
	
    protected $fillable = [
        'car_id', 'user_id', 'category', 'title', 'content', 'price', 'km', 'make', 'model', 'year', 'country', 'date'
    ];
}
