<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
     public $timestamps = false;
	
    protected $fillable = [
        'car_id', 'user_id', 'user_name', 'status', 'owner'
    ];
}
