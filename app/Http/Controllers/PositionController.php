<?php

namespace App\Http\Controllers;

use App\Http\Requests\Position\PositionStoreRequest;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request){
        $data = $request->all();
        $positions = Position::getAll($request->route('chain') , $data['datatable']);
        $data['datatable']['pagination']['total'] = $positions['total'];
        return response()->json(["data"=>$positions['position'],
            "meta"=>$data['datatable']['pagination']],200);
    }
    public function store(Request $baseRequest,PositionStoreRequest $request){
        $params  = $baseRequest->route()->parameters();
        $data = $request->all();
        $position = new Position($data);
        $position->chain_id = $params['chain'];
        if($position->save()){
            return response()->json(["data"=>["position"=>$position],"status"=>"OK"],200);
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
