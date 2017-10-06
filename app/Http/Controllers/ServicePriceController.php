<?php

namespace App\Http\Controllers;


use App\Http\Requests\ServicePrice\ServicePriceStoreRequest;
use App\Http\Requests\ServicePrice\ServicePriceUpdateRequest;
use App\Http\Services\CheckOwnService;
use App\Models\ServicePrice;

class ServicePriceController extends Controller
{
    public function index(){
        $servicePrice = ServicePrice::getAll();
        return response()->json($servicePrice,200);
    }

    public function show(){

    }

    public function store(ServicePriceStoreRequest $request){
        $data = $request->all();
        if(!CheckOwnService::ownService($request,$data['price_level_id'])){
            return CheckOwnService::priceLevelErrorResponse();
        }
        if(!CheckOwnService::ownService($request,$data['service_id'])){
            return CheckOwnService::serviceErrorResponse();
        }
        $servicePrice = new ServicePrice($data);
        if($servicePrice->save()){
            return response()->json(["data"=>$servicePrice,"status"=>"OK"],200);
        }
    }

    public function update(ServicePriceUpdateRequest $request){
        $params = $request->route()->parameters();
        $data = $request->all();
        $servicePrice = ServicePrice::getOne($params);
        dd($servicePrice);
        if(!$servicePrice){
            return response()->json(["status"=>"ERROR", "message"=>"The ServicePrice have not been found!"],400);
        }
        if($data['service_id']){
            if(!CheckOwnService::ownService($request,$data['service_id'])){
                return CheckOwnService::serviceErrorResponse();
            }
        }
        $servicePrice->fill($data);
        if($servicePrice->save()){
            return response()->json(["data"=>["ServicePrice"=>$servicePrice]],200);
        }
    }

    public function destroy(){

    }
}