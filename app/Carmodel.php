<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carmodel extends Model
{
    
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'make', 'model', 'year', 'engine' , 'famous'
	];
}
