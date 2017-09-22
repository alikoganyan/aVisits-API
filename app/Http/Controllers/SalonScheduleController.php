<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalonSchedule\SalonScheduleStoreRequest;
use App\Http\Requests\SalonSchedule\SalonScheduleUpdateRequest;
use App\Http\Services\SAlonScheduleService;
use App\Http\Services\SalonService;
use App\Models\SalonSchedule;
use Illuminate\Http\Request;

class SalonScheduleController extends Controller
{
    public function index(Request $request)
    {
        $salonSchedules = SalonSchedule::getScheduleList($request);
        return response()->json($salonSchedules, 200);
    }

    public function create()
    {

    }

    public function store(Request $baseRequest, SalonScheduleStoreRequest $request)
    {
//        $params = $request->route()->parameters();
        $data = $request->all();
        if (!SalonService::ownSalon($baseRequest, $data['salon_id'])) {
            return SalonService::ownErrorResponse();
        }
        $salonSchedule = new SalonSchedule($data);
        $salonSchedule->salon_id = $data['salon_id'];
        $salonSchedule->save();
        return response()->json($salonSchedule, 200);
    }

    public function edit()
    {

    }

    public function update(Request $baseRequest,SalonScheduleUpdateRequest $request)
    {
        $params = $request->route()->parameters();
        $data = $request->all();
        if(!empty($params['salon_schedule'])){
            if(!SalonScheduleService::ownSalonSchedule($params['salon_schedule'])){
                return SalonScheduleService::ownErrorResponse();
            }
        }
        if(isset($data['salon_id']) && !empty($data['salon_id'])){
            if (!SalonService::ownSalon($baseRequest, $data['salon_id'])) {
                return SalonService::ownErrorResponse();
            }
        }
        $salon_schedule = SalonSchedule::find((integer)$params['salon_schedule']);
        $salon_schedule->fill($data);
        if($salon_schedule->save()){
            return response()->json($salon_schedule,200);
        }else{
            return response()->json(["error"=>"UPDATE Error"],400);
        }
    }

    public function destroy(Request $request)
    {
        $params = $request->route()->parameters();
        if(!empty($params['salon_schedule'])){
            if(!SalonScheduleService::ownSalonSchedule($params['salon_schedule'])){
                return SalonScheduleService::ownErrorResponse();
            }
        }
        $salon_schedule = SalonSchedule::find((integer)$params['salon_schedule']);
        $salon_schedule->delete();
        return response()->json(["success"=>"1"],200);
    }
}
