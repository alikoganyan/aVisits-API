<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = "schedules";

    protected $fillable = [
        'salon_id',
        'employee_id',
        'start_time',
        'end_time',
        'day',
        'working_status',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [

    ];

    /**
     * Get by id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public static function getById($id)
    {
        $schedule = self::query()->with(['periods'])->find($id);
        return $schedule;
    }

    /**
     * Create employee schedule
     *
     * @param $salonId
     * @param $employeeId
     * @param $type
     * @param $workingDays
     * @param $weekend
     * @param $date
     * @return Schedule|array
     */
    public static function create($salonId, $employeeId, $type, $workingDays, $weekend, $date)
    {
        $schedule = new self();
        if ($type == 1) {
            $schedule->salon_id = $salonId;
            $schedule->employee_id = $employeeId;
            $schedule->type = $type;
            $schedule->working_days = $workingDays;
            $schedule->weekend = $weekend;
            $schedule->date = $date;
        }
        if ($schedule->save()) {
            return $schedule;
        }
        return [];
    }

    public static function edit($scheduleId, $salonId, $employeeId, $type, $workingDays, $weekend, $date)
    {
        $schedule = self::getById($scheduleId);
        if ($schedule) {
            if ($type == 1) {
                $schedule->salon_id = $salonId;
                $schedule->employee_id = $employeeId;
                $schedule->type = $type;
                $schedule->working_days = $workingDays;
                $schedule->weekend = $weekend;
                $schedule->date = $date;
            }
            if ($schedule->save()) {
                return $schedule;
            }
        }
        return [];
    }

    /**
     * Relationship for schedule periods
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function periods()
    {
        return $this->hasMany('App\Models\SchedulePeriod', 'schedule_id', 'id');
    }
}
