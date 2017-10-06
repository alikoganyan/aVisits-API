<?php

namespace App\Http\Controllers;


use App\Http\Requests\ServicePrice\ServicePriceStoreRequest;
use App\Http\Services\CheckOwnService;
use App\Models\ServicePrice;

class ServicePriceController extends Controller
{
    public function index(){
        $servicePrice = ServicePrice::getAll();
        return response()->json($servicePrice,200);
    }

    public function store(ServicePriceStoreRequest $request){
        $data = $request->all();
        if(!CheckOwnService::ownService($request,$data['service_id'])){
            return CheckOwnService::serviceErrorResponse();
        }
        $servicePrice = new ServicePrice($data);
        dd($servicePrice);

    }

    public function show(){

    }

    public function update(){

    }

    public function destroy(){

    }
}