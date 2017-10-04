<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price_level_id',
        'service_id',
        'price',
        'from',
        'created_at',
        'updated_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public static function getAll(){
        return self::with('level')->get();
    }

    public function level(){
        return $this->hasOne('App\Models\PriceLevel','id','price_level_id');
    }
}
