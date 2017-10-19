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
        'title', 'img', 'country', 'city', 'address', 'latitude', 'longitude', 'current_time', 'user_id', 'chain_id'
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
        return self::all();
    }

    public function schedule()
    {
        return $this->hasMany('App\Models\SalonSchedule', 'salon_id', 'id');
    }
}
