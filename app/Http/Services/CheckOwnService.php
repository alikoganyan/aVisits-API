<?php
namespace App\Http\Services;

use App\Models\Service as ServiceModel;
use Illuminate\Http\Request;

class CheckOwnService
{
    public static function ownService(Request $request , $service_id){
        $chainId = $request->route('chain') || null;
        $service = ServiceModel::where(['chain_id'=>$chainId,'id'=>$service_id])->count();
        if($service !== 0){
            return true;
        }
        return false;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function serviceErrorResponse(){
        return response()->json(["error" => "permission error", "message" => "incorrect service_id"], 400);
    }
}