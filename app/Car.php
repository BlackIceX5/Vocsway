<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Cache;
class Car extends Model
{	
	public $timestamps = false;
	
    protected $fillable = [
        'user_id', 'make', 'model', 'year', 'engine', 'fuel', 'nickauto', 'story', 'score', 'date'
    ];
	
	public function isOnline()
	{
		return Cache::has('online' . $this->user_id);
	}
}
