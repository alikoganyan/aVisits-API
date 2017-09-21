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
        'salon_id',
    ];

    public static function days_of_week()
    {
        return [
            "1" => ["short" => "ПН", "working" => 1, "title" => "Понедельник"],
            "2" => ["short" => "ВТ", "working" => 1, "title" => "Вторник"],
            "3" => ["short" => "СР", "working" => 1, "title" => "Среда"],
            "4" => ["short" => "ЧТ", "working" => 1, "title" => "Четверг"],
            "5" => ["short" => "ПТ", "working" => 1, "title" => "Пятница"],
            "6" => ["short" => "СБ", "working" => 0, "title" => "Суббота"],
            "7" => ["short" => "ВС", "working" => 0, "title" => "Воскресенье"]
        ];
    }

    public static function getScheduleList(Request $request)
    {
        $filters = $request->route()->parameters();
        return self::join("salons", "salon_schedules.salon_id", "=", "salons.id")
            ->where(['salons.chain_id' => $filters['chain'], 'user_id' => Auth::id()])
            ->get();
    }
}
