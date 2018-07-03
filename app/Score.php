<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
     public $timestamps = false;
	
    protected $fillable = [
        'car_id', 'points', 'score'
    ];
}
