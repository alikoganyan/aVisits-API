<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'img', 'start_workingtime', 'end_workingtime', 'city', 'address', 'latitude', 'longitude', 'user_id', 'chain_id'
    ];

}
