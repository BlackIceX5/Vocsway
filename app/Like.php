<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps = false;
	
    protected $fillable = [
        'type', 'item_id', 'user_id', 'user_name', 'status', 'owner'
    ];
}
