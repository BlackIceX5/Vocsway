<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VotingProces extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'car1', 'car2', 'car3', 'resCar1', 'resCar2', 'resCar3', 'date', 'users'
    ];
}
