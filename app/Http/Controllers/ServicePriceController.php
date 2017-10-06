<?php

namespace App\Http\Controllers;


use App\Http\Requests\ServicePrice\ServicePriceStoreRequest;
use App\Models\ServicePrice;

class ServicePriceController extends Controller
{
    public function index(){
        $servicePrice = ServicePrice::getAll();
        return response()->json($servicePrice,200);
    }

    public function store(ServicePriceStoreRequest $request){
        
    }

    public function show(){

    }

    public function update(){

    }

    public function destroy(){

    }
}