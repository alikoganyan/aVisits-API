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
            $services = ServiceCategory::where(["chain_id"=>$this->chain])
                ->with(['groups'=>function($groups){
                    $groups->with('services');
                }])
                ->get();
            dd($services->toArray());
        }
        return response()->json(['data' => $services], 200);
    }
}