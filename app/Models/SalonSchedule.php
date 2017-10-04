<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalonSchedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'salon_id',
        'start',
        'end',
        'num_of_day',
        'working_status',
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

    public static function days_of_week($key = null)
    {
        $days =  [
            "1" => ["short" => "ПН", "working" => 1, "title" => "Понедельник"],
            "2" => ["short" => "ВТ", "working" => 1, "title" => "Вторник"],
            "3" => ["short" => "СР", "working" => 1, "title" => "Среда"],
            "4" => ["short" => "ЧТ", "working" => 1, "title" => "Четверг"],
            "5" => ["short" => "ПТ", "working" => 1, "title" => "Пятница"],
            "6" => ["short" => "СБ", "working" => 0, "title" => "Суббота"],
            "7" => ["short" => "ВС", "working" => 0, "title" => "Воскресенье"]
        ];
        if($key !== null && isset($days[$key])){
            return $days[$key];
        }
        return $days;
    }
    public static function default_schedules($salon_id = null){
        $days_of_week = self::days_of_week();
        $default = [];
        foreach($days_of_week as $key => $day){
            $value = [
                "salon_id" => $salon_id,
                "num_of_day" => $key,
                "working_status" => $day['working'],
                "start"=>null,
                "end"=>null
            ];
            if($day['working']){
                $value["start"] = "10:00:00";
                $value["end"] = "22:00:00";
            }
            array_push($default,$value);
        }
        return $default;
    }
    public static function getScheduleList(Request $request)
    {
        $filters = $request->route()->parameters();
        return self::join("salons", "salon_schedules.salon_id", "=", "salons.id")
            ->select(['salon_schedules.*'])
            ->where(['salons.chain_id' => $filters['chain'], 'user_id' => Auth::id()])
            ->get();
    }
}
