<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function index(Request $request){
        $chain = $request->route('chain');
        $serviceCategory = ServiceCategory::where(["chain_id"=>$chain])->get();
        return response()->json($serviceCategory,200);
    }

    public function create(){
        return response()->json(["success"=>"coming soon"],200);
    }

    public function store(ServiceCategoryRequest $request){
        $data  = $request->only('title');
        $chain_id = (integer)$request->route('chain');
        $serviceCategory = new ServiceCategory($data);
        $serviceCategory->chain_id = $chain_id;
        if($serviceCategory->save()){
            return response()->json($serviceCategory,200);
        }
        return response()->json(["error"=>"save error"],400);
    }

    public function edit(){
        return response()->json(["success"=>"coming soon"],200);
    }

    public function update(ServiceCategoryRequest $request){
        $params = $request->route()->parameters();
        $model = ServiceCategory::where(["id"=>$params['service_category'],'chain_id'=>$params['chain']])->first();
        if(!$model){
            return response()->json(["error"=>"incorrect service category"],400);
        }
        $model->fill($request->all());
        $model->chain_id = $params['chain'];
        if($model->save()){
            return response()->json($model,200);
        }
        return response()->json(["error"=>"update error"],200);
    }

    public function destroy(){
        return response()->json(["success"=>"coming soon"],200);
    }
}
