<?php
namespace App\Http\Controllers\Widget;
use App\Http\Controllers\Controller;
use App\Models\Salon;

class WidgetSalonController extends Controller
{
    public function salonsCities(){
        $cities = Salon::salonsCities();
        $data = collect($cities)->map(function($x){
            return $x->city;
        });
        return response()->json(['data' => ['cities'=>$data]], 200);
    }
}