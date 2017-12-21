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
            $services = ServiceCategory::getCategoriesWithServices($this->chain,$filter);
            $services = $services->toArray();
            /*remove the objects which have not any service*/
            foreach ($services as $cKey=>&$category) {
                foreach ($category["groups"] as $gKey=>$group) {
                    if(count($group["services"]) <= 0 ){
                        unset($category["groups"][$gKey]);
                    }
                }
                if(count($category["groups"]) <= 0 ){
                    unset($services[$cKey]);
                }
            }
            $services = ["categories"=>$services];
        }
        return response()->json(['data' => $services], 200);
    }
}