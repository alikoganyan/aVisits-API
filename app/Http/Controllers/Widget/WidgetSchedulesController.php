<?php
namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
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

    public function getTimeToInteger($value)
    {
        $times = explode(':',$value);
        $times = collect($times)->map(function($item){
            return (integer)$item;
        });
        return ($times[0]*60) + $times[0];
    }
    public function getWorkingStatus($employeeSchedule,$date) {
        if($employeeSchedule['type'] == 1){
            return $employeeSchedule['working_status'];
        }
        if($employeeSchedule['type'] == 2){
            $days = Carbon::parse($date)->diffInDays(Carbon::parse($employeeSchedule['date'])) +1;
            $sumOfDays = (integer)$employeeSchedule['working_days'] + (integer)$employeeSchedule['weekend'];
            $nowIs = $days%$sumOfDays;
            if($nowIs > $employeeSchedule['working_days'] || $nowIs == 0){
                return 0;
            }
            else{
                return 1;
            }
        }
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
                "schedules"=>$this->freeTimeOfEmployee($filter)
            ]);
        }


        return response()->json(["data"=>["employees"=>$response]],200);
    }

    private function freeTimeOfEmployee($filter) {
        $appointments = Appointment::getAppointments($filter);
        $schedules = Schedule::getWorkingHours($filter);
        $schedulesArray = $schedules->toArray();
        $workingStatus = $this->getWorkingStatus($schedulesArray,$filter['date']);
        $schedulesArray['working_status'] = $workingStatus;
        if(count($appointments) > 0 && $workingStatus == 1) {
            foreach ($appointments as $appointment) {
                $from_time = $this->getTimeToInteger($appointment['from_time']);
                $to_time = $this->getTimeToInteger($appointment['to_time']);
                foreach ($schedulesArray['periods'] as &$sh) {
                    $start =  $this->getTimeToInteger($sh['start']);
                    $end =  $this->getTimeToInteger($sh['end']);
                    /*esli nachalo zapisi vnutri perioda*/
                    if( $start <= $from_time && $from_time <= $end) {
                        /*esli konec zapisi toje vnutri perioda*/
                        if($start <= $to_time && $to_time <= $end) {
                            /*esli nachalo sovpadaet s nachalom perioda*/
                            if($from_time == $start ) {
                                /*esli konec toje sovpadaet s koncom perioda*/
                                if($to_time == $end){
                                    $sh['removed'] = 1;
                                    continue;
                                }
                                else{
                                    $sh['start'] = $appointment['to_time'];
                                }
                            }
                            else{
                                /*esli konec sovpadaet s koncom perioda*/
                                if($to_time == $end) {
                                    $sh['end'] = $appointment['from_time'];
                                }
                                /* from_time i end time vnutri Perioda*/
                                else {
                                    $tEnd = $sh['end'];
                                    $sh['end'] = $appointment['from_time'];

                                    $schedulesArray['periods'][] = [
                                        "schedule_id"=>$sh['schedule_id'],
                                        "start"=>$appointment['to_time'],
                                        "end"=>$tEnd];
                                }
                            }
                        }
                    }
                }
            }
            foreach ($schedulesArray['periods'] as $key=>$period){
                if(isset($period['removed']) && $period['removed'] == 1){
                    array_splice($schedulesArray['periods'],$key,1);
                }
            }
        }
        return $schedulesArray;
    }

}