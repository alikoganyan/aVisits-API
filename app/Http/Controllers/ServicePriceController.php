<?php

namespace App\Http\Controllers;


use App\Models\ServicePrice;

class ServicePriceController extends Controller
{
    public function index(){
        $servicePrice = ServicePrice::getAll();
        return response()->json($servicePrice,200);
    }

    public function store(){

    }

    public function show(){

    }

    public function update(){

    }

    public function destroy(){

    }
}