<?php
namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Http\Requests\Widget\CalendarFilterRequest;
use App\Models\Appointment;
use App\Models\SalonSchedule;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;

class WidgetSchedulesController extends Controller
{
    public function __construct(Request $request)
    {
        $this->chain = $request->route('chain');
    }

    public function employeeCalendar(CalendarFilterRequest $request) {
        $filters = $request->all();
        $filter['salon_id'] = $filters['salon_id'];
        $from = Carbon::parse($filters['from']);
        $to = Carbon::parse($filters['to']);
        $dates = [];
        while($from->lessThanOrEqualTo($to)) {
            array_push($dates,$from->format("Y-m-d"));
            $from = $from->addDay(1);
        }
        $response = [];
        foreach ($dates as $date) {
            $item = ["date"=>$date,"working_status"=>0];
            $filter['date'] = $date;
            $salon_schedule_status = SalonSchedule::getStatusByDate($filter['salon_id'],$date);
            if($salon_schedule_status === 1){
                foreach ($filters['employees'] as $employee){
                    $filter['employee_id'] = $employee;
                    $employee_schedule = $this->status($filter);
                    if(count($employee_schedule) <= 0) {
                        continue;
                    }
                    $employee_schedule['working_status'] = $this->getWorkingStatus($employee_schedule,$date);
                    if($employee_schedule['working_status'] === 1){
                        $item['working_status'] = 1;
                        break;
                    }
                }
            }
            array_push($response,$item);
        }
        return response()->json(["data"=>["calendar"=>$response]],200);
    }

    public function freeTimesTest(Request $request) {
        $filters = $request->post();
        if(Carbon::today()->gt(Carbon::parse($filters['date']))) {
            return response()->json(["message"=>"Invalid recording date" , "status"=>"ERROR"],400);
        }
        $filter = [];
        $filter['salon_id'] = $filters['salon_id'];
        $filter['date'] = $filters['date'];
        $response = [];
        $salonSchedule = SalonSchedule::getScheduleByDate($filter['salon_id'],$filter['date']);
        dd($salonSchedule);
        foreach ($filters['employees'] as $employee) {
            $filter['employee_id'] = $employee;
            array_push($response,[
                "employee_id"=>$employee,
                "schedule"=>$this->freeTimeOfEmployee($filter)
            ]);
        }
        return response()->json(["data"=>["employees"=>$response]],200);
    }

    public function freeTimes(Request $request) {
        $filters = $request->post();
        if(Carbon::today()->gt(Carbon::parse($filters['date']))) {
            return response()->json(["message"=>"Invalid recording date" , "status"=>"ERROR"],400);
        }
        $filter = [];
        $filter['salon_id'] = $filters['salon_id'];
        $filter['date'] = $filters['date'];
        $response = [];
        foreach ($filters['employees'] as $employee) {
            $filter['employee_id'] = $employee;
            array_push($response,[
                "employee_id"=>$employee,
                "schedule"=>$this->freeTimeOfEmployee($filter)
            ]);
        }
        return response()->json(["data"=>["employees"=>$response]],200);
    }

    private function status($filter) {
        $dayOfWeek = null;
        $dayOfWeek = Carbon::parse($filter['date'])->dayOfWeek;
        if($dayOfWeek === 0){
            $dayOfWeek = 7;
        }
        $query = Schedule::query();
        $query->select(["working_status","date","type","working_days","weekend"])
            ->where(["salon_id"=>$filter['salon_id'],"employee_id"=>$filter['employee_id']])
            ->where("date","<=",$filter["date"])
            ->where(function($where) use($dayOfWeek){
                $where->where("num_of_day","=",$dayOfWeek)->orWhereNull("num_of_day")->orWhere("num_of_day","=",0);
            })->orderBy('date','desc');
        $schedule = $query->first();
        if($schedule)
            return $schedule->toArray();
        return [];
    }

    private function getTimeToInteger($value)
    {
        $times = explode(':',$value);
        $times = collect($times)->map(function($item){
            return (integer)$item;
        });
        return ($times[0]*60) + $times[0];
    }

    private function getWorkingStatus($employeeSchedule,$date) {
        if($employeeSchedule['type'] == 1) {
            return $employeeSchedule['working_status'];
        }
        if($employeeSchedule['type'] == 2) {
            $days = Carbon::parse($date)->diffInDays(Carbon::parse($employeeSchedule['date'])) +1;
            $sumOfDays = (integer)$employeeSchedule['working_days'] + (integer)$employeeSchedule['weekend'];
            $nowIs = $days%$sumOfDays;
            if($nowIs > $employeeSchedule['working_days'] || $nowIs == 0) {
                return 0;
            }
            else{
                return 1;
            }
        }
    }

    private function freeTimeOfEmployee($filter) {
        $appointments = Appointment::getAppointments($filter);
        $schedules = Schedule::getWorkingHours($filter);
        if(!$schedules){
            return null;
        }
        $schedulesArray = $schedules->toArray();
        $schedulesArray['free_periods'] = $schedulesArray['periods'];
        $workingStatus = $this->getWorkingStatus($schedulesArray,$filter['date']);
        $schedulesArray['working_status'] = $workingStatus;
        if(count($appointments) > 0 && $workingStatus == 1) {
            foreach ($appointments as $appointment) {
                $from_time = $this->getTimeToInteger($appointment['from_time']);
                $to_time = $this->getTimeToInteger($appointment['to_time']);
                foreach ($schedulesArray['free_periods'] as &$sh) {
                    $start =  $this->getTimeToInteger($sh['start']);
                    $end =  $this->getTimeToInteger($sh['end']);
                    /*если начало записи внутри периода*/
                    if( $start <= $from_time && $from_time <= $end) {
                        /*если конец записи тоже внутри периода*/
                        if($start <= $to_time && $to_time <= $end) {
                            /*если начало совпадает с началом периода*/
                            if($from_time == $start ) {
                                /*Если конец тоже совпадает с концом периода*/
                                if($to_time == $end){
                                    $sh['removed'] = 1;
                                    continue;
                                }
                                else{
                                    $sh['start'] = $appointment['to_time'];
                                }
                            }
                            else{
                                /*Если начало записи не совпадает с началом периода, но конец совпадает с концом периода */
                                if($to_time == $end) {
                                    $sh['end'] = $appointment['from_time'];
                                }
                                /*from_time i end time  внутри периода и не совпадают с началом и концом периода*/
                                else {
                                    $tEnd = $sh['end'];
                                    $sh['end'] = $appointment['from_time'];

                                    $schedulesArray['free_periods'][] = [
                                        "schedule_id"=>$sh['schedule_id'],
                                        "start"=>$appointment['to_time'],
                                        "end"=>$tEnd];
                                }
                            }
                        }
                    }
                }
            }
            foreach ($schedulesArray['free_periods'] as $key=>$period){
                if(isset($period['removed']) && $period['removed'] == 1){
                    array_splice($schedulesArray['free_periods'],$key,1);
                }
            }
        }
        return $schedulesArray;
    }

}