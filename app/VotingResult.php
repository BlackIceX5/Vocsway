<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VotingResult extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'carId', 'make', 'model', 'nickAuto', 'votes', 'date'
    ];
}
