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
        'title', 'img', 'country','city', 'address', 'latitude', 'longitude', 'current_time','user_id', 'chain_id'
    ];

    public static function getAll(){
        return self::all();
    }
}
