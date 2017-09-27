<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request) {
        $schedules = Schedule::join("salons","salons.id","=","schedules.salon_id")
            ->where(["salons.chain_id"=>$request->route('chain')])
            ->get();
        dd($schedules);
    }

    public function create(){
        
    }

    public function store(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function destroy(){

    }
}
