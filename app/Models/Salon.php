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
        'title', 'img', 'country', 'city', 'address', 'street_number', 'latitude', 'longitude', 'current_time', 'user_id', 'chain_id','notify_about_appointments'
    ];

    public static function def_notifications_about_appointments($key = null)
    {
        $notifications = [
            "1h11" => "В день визита за 1 час, не позже 11",
            "2h11" => "В день визита за 2 час, не позже 11",
            "3h11" => "В день визита за 3 час, не позже 11",
            "1d19" => "За 1 день в 19 часов",
            "1d12" => "За 1 день в 12 часов",
            "2d12" => "За 2 дня в 12 часов",
            "3d12" => "За 3 дня в 12 часов",
            "7d12" => "За 7 дней в 12 часов"
        ];

        if ($key !== null && isset($notifications[$key])) {
            return $notifications[$key];
        }
        return $notifications;
    }
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

    public function getNotifyAboutAppointmentsAttribute($value) {
        return explode(',',$value);
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

    public static function salonsCities($chain) {
        return Salon::select(['city'])
            ->distinct()
            ->where(['chain_id'=>$chain])
            ->orderBy('city','asc')
            ->get();
    }
}
