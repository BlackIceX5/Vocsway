<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
	public $timestamps = false;	
	
    protected $fillable = [
        'car_id', 'user_id', 'path', 'main_img'
    ];
}
