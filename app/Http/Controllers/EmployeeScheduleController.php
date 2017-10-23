<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\SchedulePeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeScheduleController extends Controller
{
    public function create(Request $request)
    {
        $data = [];
        $rules = [];
        if ($request->input('type') == 1 || !$request->input('type')) {
            $rules = [
                "salon_id" => "required|integer|exists:salons,id",
                "employee_id" => "required|integer",
                "type" => "required|integer",
                "date" => "required|date_format:Y-m-d",
                "working_days" => "required|integer|max:7|min:0",
                "weekends" => "required",
                "periods" => "required"
            ];
        }
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $data['ExceptionHandler'] = 'invalid_request';
        } else {
            $schedule = Schedule::create($request->input('salon_id'), $request->input('employee_id'), $request->input('type'), $request->input('working_days'), $request->input('weekends'), Carbon::parse($request->input('date'))->format('Y-m-d'));
            foreach ($request->input('periods') as $key => $value) {
                $period = SchedulePeriod::add($schedule->id, Carbon::parse($value['start'])->format('H:i'), Carbon::parse($value['end'])->format('H:i'));
            }
            $schedule = Schedule::getById($schedule->id);
            $data['data'] = $schedule;
        }
        return response()->json($data, 200);
    }

    public function edit(Request $request)
    {
        $data = [];
        $rules = [];
        if ($request->input('type') == 1 || !$request->input('type')) {
            $rules = [
                "salon_id" => "required|integer|exists:salons,id",
                "employee_id" => "required|integer",
                "type" => "required|integer",
                "date" => "required|date_format:Y-m-d",
                "working_days" => "required|integer|max:7|min:0",
                "weekends" => "required",
                "periods" => "required"
            ];
        }
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $data['ExceptionHandler'] = 'invalid_request';
        } else {
            $schedule = Schedule::edit($request->input('id'), $request->input('salon_id'), $request->input('employee_id'), $request->input('type'), $request->input('working_days'), $request->input('weekends'), Carbon::parse($request->input('date'))->format('Y-m-d'));
            $periodIds = [];
            foreach ($request->input('periods') as $key => $value) {
                if (isset($value['id'])) {
                    $period = SchedulePeriod::edit($value['id'], $schedule->id, Carbon::parse($value['start'])->format('H:i'), Carbon::parse($value['end'])->format('H:i'));
                } else {
                    $period = SchedulePeriod::add($schedule->id, Carbon::parse($value['start'])->format('H:i'), Carbon::parse($value['end'])->format('H:i'));
                }
                $periodIds['id'] = $period->id;
            }
            if(count($periodIds)>0) {
                SchedulePeriod::deleteExceptIds($schedule->id,$periodIds);
            }
            $schedule = Schedule::getById($schedule->id);
            $data['data'] = $schedule;
            $data['status'] = 'OK';
        }
        return response()->json($data, 200);
    }
}