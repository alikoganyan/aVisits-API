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
     * Get employee by id
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
     * Get employee by employee id and num of day
     *
     * @param $salonId
     * @param $employeeId
     * @param $numOfDay
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getByEmployeeIdAndNumOfDay($salonId, $employeeId, $numOfDay)
    {
        $schedule = self::query()->where('salon_id', $salonId)->where('employee_id', $employeeId)->where('num_of_day', $numOfDay)->get();
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
    public static function create($salonId, $employeeId, $type, $workingStatus, $workingDays = 0, $weekend = 0, $numOfDay = 0, $date)
    {
        $schedule = new self();
        $schedule->salon_id = $salonId;
        $schedule->employee_id = $employeeId;
        $schedule->type = $type;
        if ($type == 2) {
            $schedule->working_status = $workingStatus;
        }
        if ($workingDays) {
            $schedule->working_days = $workingDays;
        }
        if ($weekend) {
            $schedule->weekend = $weekend;
        }
        if ($numOfDay) {
            $schedule->num_of_day = $numOfDay;
        }
        $schedule->date = $date;
        if ($schedule->save()) {
            return $schedule;
        }
        return [];
    }

    /**
     * Edit employee schedule
     *
     * @param $scheduleId
     * @param $salonId
     * @param $employeeId
     * @param $type
     * @param $workingDays
     * @param $weekend
     * @param $date
     * @return Schedule|array|\Illuminate\Database\Eloquent\Collection|Model|null|static[]
     */
    public static function edit($scheduleId, $salonId, $employeeId, $type, $workingStatus, $workingDays = 0, $weekend = 0, $numOfDay = 0, $date)
    {
        $schedule = self::getById($scheduleId);
        $schedule->salon_id = $salonId;
        $schedule->employee_id = $employeeId;
        $schedule->type = $type;
        if ($type == 2) {
            $schedule->working_status = $workingStatus;
        }
        if ($workingDays) {
            $schedule->working_days = $workingDays;
        }
        if ($weekend) {
            $schedule->weekend = $weekend;
        }
        if ($numOfDay) {
            $schedule->num_of_day = $numOfDay;
        }
        $schedule->date = $date;
        if ($schedule->save()) {
            return $schedule;
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
