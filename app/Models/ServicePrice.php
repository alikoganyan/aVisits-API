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
        'inactive',
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

    public static function getAll()
    {
        return self::with('level')->get();
    }

    public function level()
    {
        return $this->hasOne('App\Models\PriceLevel', 'id', 'price_level_id');
    }

    public static function getOne($params)
    {
        return self::select((new self)->getTable().'.*')->join("price_levels", "price_levels.id", "=", "service_prices.price_level_id")
            ->where(["price_levels.chain_id" => $params["chain"], "service_prices.id" => $params['service_price']])
            ->first();
    }
}
