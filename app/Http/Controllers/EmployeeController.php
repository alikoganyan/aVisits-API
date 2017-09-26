<?php
namespace App\Http\Controllers;

use App\Http\Requests\Employee\EmployeeStoreRequest;
use App\Http\Requests\Employee\EmployeeUpdateRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use File;

class EmployeeController extends Controller
{
    public function index(Request $request){
        $params = $request->route()->parameters();
        $employee = Employee::where(['chain_id'=>$params['chain']])->get();
        return response()->json(['data'=>$employee],200);
    }
    public function create(){

    }

    public function store(Request $baseRequest,EmployeeStoreRequest $request){
        $params = $request->route()->parameters();
        $employee = New Employee($request->all());
        $employee->chain_id =  (integer)$params['chain'];
        if($request->hasFile('img')){
            $file = $this->upload($baseRequest);
            if($file){
                $employee->photo = $file['fileName'];
            }
        }
        if($employee->save()){
            return response()->json(["data" => ["employee"=>$employee]],200);
        }
        return response()->json(["error" => "store Error"],400);
    }

    public function show(Request $request){
        $model = Employee::where(["id"=>$request->route('employee'),"chain_id"=>$request->route('chain')])->first();
        return response()->json(["data"=>["employee"=>$model]],200);
    }

    public function edit(){

    }
    public function update(Request $baseRequest,EmployeeUpdateRequest $request){
        $params = $request->route()->parameters();
        $data = $request->all();
        $employee = Employee::where(['chain_id'=>$params['chain'],'id'=>$params['employee']])->first();
        if($request->hasFile('img')){
            $file = $this->upload($baseRequest);
            if($file){
                $employee->photo = $file['fileName'];
            }
        }
        $employee->fill($data);
        if($employee->save()){
            return response()->json(["data" => ["employee"=>$employee]],200);
        }
        return response()->json(["error" => "update Error"],400);
    }

    public function destroy(Request $request){
        $model = Employee::where(["id"=>$request->route('employee'),"chain_id"=>$request->route('chain')])->first();;
        $model->delete();
        return response()->json(["success"=>"1"],200);
    }

    public function upload(Request $request){
        $ds = DIRECTORY_SEPARATOR;
        $file = $request->file('img');
        $path = public_path("files".$ds."employee".$ds."images".$ds."photo");
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
}