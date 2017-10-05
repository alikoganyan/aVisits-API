<?php

namespace App\Http\Controllers;

use App\Http\Requests\Position\PositionStoreRequest;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request){
        $positions = Position::where(['chain_id'=>$request->route('chain')])->get();
        return response()->json(["data"=>$positions],200);
    }
    public function store(Request $baseRequest,PositionStoreRequest $request){
        $params  = $baseRequest->route()->parameters();
        $data = $request->all();
        $position = new Position($data);
        $position->chain_id = $params['chain'];
        if($position->save()){
            return response()->json(["data"=>["position"=>$position],"status"=>"OK",
                "meta"=>["field"=>"id","page"=>1,"pages"=>2,"perpage"=>10,"sort"=>"desc","total"=>18]],200);
        }
        return response()->json(["error"=>"saving error"],400);

    }
    public function show(Request $request){
        $params  = $request->route()->parameters();
        $position = Position::where(["chain_id"=>$params['chain'],"id"=>$params["position "]])->first();
        return response()->json(["data"=>["position"=>$position],"status"=>"OK"],200);
    }
    public function update(Request $baseRequest, PositionStoreRequest $request){
        $params  = $request->route()->parameters();
        $position = Position::where(["chain_id"=>$params['chain'],"id"=>$params["position "]])->first();
        $position->fill($request->all());
        if($position->save()){
            return response()->json(["data"=>["position"=>$position],"status"=>"OK"],200);
        }
        return response()->json(["error"=>"saving error"],400);
    }
    public function destroy(Request $request){
        $params  = $request->route()->parameters();
        $position = Position::where(["chain_id"=>$params['chain'],"id"=>$params["position "]])->first();
        return response()->json(["data"=>["position"=>$position],"status"=>"OK"],200);

    }
}
