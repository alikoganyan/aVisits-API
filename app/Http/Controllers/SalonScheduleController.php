<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalonSchedule\SalonScheduleStoreRequest;
use App\Models\SalonSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SalonScheduleController extends Controller
{
    public function index(Request $request){
        $params = $request->route()->parameters();
        $salonSchedules = SalonSchedule::getScheduleList($request);
        return response()->json($salonSchedules,200);
    }

    public function create(){

    }

    public function store(SalonScheduleStoreRequest $request){

    }

    public function edit(){

    }

    public function update(){

    }

    public function destroy(){

    }
}
