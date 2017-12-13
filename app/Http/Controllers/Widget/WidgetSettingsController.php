<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\WidgetSettings;
use Illuminate\Http\Request;

class WidgetSettingsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->chain = $request->route('chain');
    }

    public function index(Request $request)
    {
        $status = 200;
        $responseBody = ["data"=>[]];
        $params = $this->filterRequestData($request->all(),["w_steps_service","w_steps_employee","w_color"]);
        $settings = WidgetSettings::find($this->chain);
        if($settings->w_let_check_steps) {
            unset($settings->w_steps_g);
            $status = 200;
            $responseBody["data"]["settings"] = $settings;
        }else{
            unset($settings->w_steps_service);
            unset($settings->w_steps_employee);
            /* Если не разрешено пользователю менять последовательность нутей, но производится попытка изменения последовательности */
            if((isset($params["w_steps_service"]) && !empty($params["w_steps_service"])) || (isset($params["w_steps_employee"]) && !empty($params["w_steps_employee"])) ){
                $status = 400;
                $responseBody["data"] = [];
                $responseBody["status"] = "ERROR";
                $responseBody["message"] = "selectSteps";
                $responseBody["description"] = "You do not have the right to change the sequence of steps!";
            }elseif (isset($params["w_color"]) && !empty($params["w_color"])){
                $status = 200;
                $responseBody["data"]["settings"] = $settings;
            }
        }
        return response()->json($responseBody,$status);
    }
    public function validateParams($params)
    {
        if(isset($params['w_steps_service']) && !empty($params['w_steps_service'])){

        }
        if(isset($params['w_steps_employee']) && !empty($params['w_steps_employee'])){

        }
        if(isset($params['w_steps_employee']) && !empty($params['w_steps_employee'])){

        }
    }
    public function filterRequestData($params, $keys)
    {
        $params = collect($params)->filter(function ($item,$key) use ($keys) {
            return in_array($key,$keys);
        });
        return $params->all();
    }
}