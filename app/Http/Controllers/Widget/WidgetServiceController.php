<?php
namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class WidgetServiceController extends Controller
{
    public function __construct(){

    }
    public function services(Request $request){
        $filter = $request->post();
        $services = Service::getServices($filter);
        return response()->json(['data' => $services], 200);
    }
}