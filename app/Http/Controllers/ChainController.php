<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chain;

Class ChainController extends Controller
{
    public function index(){
        return response()->json(['data'=>'index'],200);
    }

    public function store(Request $request){
        return response()->json(['data'=>'store'],200);
    }

    public function edit(){
        return response()->json(['data'=>'edit'],200);
    }

    public function update(){
        return response()->json(['data'=>'update'],200);
    }

    public function destroy(){
        return response()->json(['data'=>'destroy'],200);
    }

    public function firstChain(){
        $chain = new Chain();
        $chain->fill(["title"=>"Сеть 1","description"=>"First Chain","user_id"=>Auth::id()]);
        if($chain->save()){
            return $chain;
        }
        return [];
    }
}