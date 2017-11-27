<?php
namespace App\Http\Controllers\Widget;
use App\Http\Controllers\Controller;
use App\Models\Salon;
use Illuminate\Http\Request;

class WidgetSalonController extends Controller
{
    private $chain;

    public function __construct(Request $request)
    {
        $this->chain = $request->route('chain');

    }

    public function salonsCities(Request $request){
        $cities = Salon::salonsCities($this->chain);
        $data = collect($cities)->map(function($x){
            return $x->city;
        });
        return response()->json(['data' => ['cities'=>$data]], 200);
    }
}