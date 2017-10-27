<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'img', 'country', 'city', 'address', 'street_number', 'latitude', 'longitude', 'current_time', 'user_id', 'chain_id'
    ];

    /**
     * Get salon by id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public static function getById($id)
    {
        $salon = self::query()->with(['schedule'])->find($id);
        return $salon;
    }

    public static function getAll()
    {
        return self::orderBy('id','desc')->get();
    }

    /**
     * Get salons by chain id
     *
     * @param $chainId
     * @return mixed
     */
    public static function getByChainId($chainId) {
        $salons=self::where('chain_id',$chainId)->get();
        return $salons;
    }

    public function getImgAttribute($value) {
        return '/images/'.$value;
    }

    /**
     * Relationship for salon schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedule()
    {
        return $this->hasMany('App\Models\SalonSchedule', 'salon_id', 'id');
    }
}
