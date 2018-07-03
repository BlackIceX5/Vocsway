<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
	
    protected $fillable = [
        'post_id', 'user_id', 'user_name', 'comment', 'child', 'date', 'status', 'owner'
    ];
}
