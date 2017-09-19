<?php

namespace App\Http\Controllers;

use \App\Http\Requests\StoreSalonRequest;
use \App\Http\Requests\UpdateSalonRequest;
use App\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;


class SalonController extends Controller
{

    public function index(Request $request){
        $salons = Salon::getAll();
        return response()->json($salons,200);
    }

    public function create(Request $request){
        return "create";
    }

    public function store(StoreSalonRequest $request){
        $salon =  new Salon();
        $salon->fill($request->all());
        $salon->user_id = Auth::id();
        $salon->chain_id = $request->route('chain');
        if($salon->save()){
            return response()->json(Salon::find($salon->id),200);
        }
        return response()->json(["error"=>"any problem with storing data"],400);
    }

    public function show(Salon $salon){
        return response()->json($salon,200);
    }

    public function edit(StoreSalonRequest $request, Salon $salon){
        return "edit";
    }

    public function update(UpdateSalonRequest $request, Salon $salon){
        $salon->fill($request->all());
        $salon->user_id = Auth::id();
        if($salon->save()){
            return response()->json($salon,200);
        }
        return response()->json(["error"=>"any problem with storing data"],400);
    }

    public function destroy(Salon $salon){
        $salon->delete();
        return response()->json(["success"=>"1"],200);
    }

    public function haveAnySalon(){
        return Salon::join('chains','salons.chain_id','=','chains.id')
            ->where(['chains.user_id'=>Auth::id(),'salons.user_id'=>Auth::id()])
            ->count();
    }
}
