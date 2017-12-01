<?php
namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    public function freeTimes(Request $request) {
        $filter = $request->post();
        if(Carbon::today()->gt(Carbon::parse($filter['date']))) {
            return response()->json(["message"=>"Invalid recording date" , "status"=>"ERROR"],400);
        }
        $appointments = Appointment::getAppointments($filter);
        $schedules = Schedule::getWorkingHours($filter);
        $schedulesArray = $schedules->toArray();
        $freePeriods = [];
        if(count($appointments) > 0) {
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
                                    $tEnd = clone $sh['end'];
                                    $sh['end'] = $appointment['from_time'];

                                    $schedulesArray['periods'][] = [
                                        "start"=>$appointment['to_time'],
                                        "end"=>$tEnd];
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json(["data"=>["schedules"=>$schedulesArray]],200);
    }

}