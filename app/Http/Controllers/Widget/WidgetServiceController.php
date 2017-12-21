<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class WidgetServiceController extends Controller
{
    public function __construct(Request $request)
    {
        $this->chain = $request->route('chain');
    }

    public function services(Request $request)
    {
        $filter = $request->post();
        if(isset($filter['salon_id']) && !empty($filter['salon_id'])){
            $services = Service::getServices($this->chain, $filter);
        }
        else{
            $services = ServiceCategory::select(["service_categories.id","service_categories.title"])
                ->distinct()
                ->where(["service_categories.chain_id"=>$this->chain])
                ->join("service_categories as SG",function($join){
                    $join->on("service_categories.id","=","SG.parent_id");
                })
                ->with(['groups'=>function($groups){
                    $groups->select(["id","parent_id","title"])
                        ->with(['services'=>function($service){
                            $service->select(["id","service_category_id","title","description","duration"]);
                        }]);
                }])
                ->get();
            $services = ["categories"=>$services];
        }
        return response()->json(['data' => $services], 200);
    }
}