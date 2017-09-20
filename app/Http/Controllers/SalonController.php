<?php

namespace App\Http\Controllers;

use \App\Http\Requests\StoreSalonRequest;
use \App\Http\Requests\UpdateSalonRequest;
use App\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use File;

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

    public function show($salon){
        $model = Salon::find($salon);
        return response()->json($model,200);
    }

    public function edit(StoreSalonRequest $request, Salon $salon){
        return "edit";
    }

    public function update(Request $request, $salon){

        $model = Salon::find($salon);
        $model->fill($request->all());
        $model->img = null;
        $model->user_id = Auth::id();
        if($request->hasFile('img')){
            $file = $this->upload($request);
            if($file){
                $model->img = $file['fileName'];
            }
        }
        if($model->save()){
            return response()->json($model,200);
        }
        return response()->json(["error"=>"any problem with storing data"],400);
    }

    public function upload(Request $request){
        $ds = DIRECTORY_SEPARATOR;
        $file = $request->file('img');
        $path = public_path("files".$ds."salons".$ds."images".$ds."main");
        $fileName = time()."_".md5($file->getClientOriginalName()).".".$file->getClientOriginalExtension();
        if(!File::exists($path)){
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        if($file->move($path,$fileName)){
            return [
                "fileName"=>$fileName,
                "path"=>$path
            ];
        }
        else{
            return false;
        }

    }

    public function destroy($salon){
        $model = Salon::find($salon);
        $model->delete();
        return response()->json(["success"=>"1"],200);
    }

    public function haveAnySalon(){
        return Salon::join('chains','salons.chain_id','=','chains.id')
            ->where(['chains.user_id'=>Auth::id(),'salons.user_id'=>Auth::id()])
            ->count();
    }
}
