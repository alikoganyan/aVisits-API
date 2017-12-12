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

    public function index()
    {
        $settings = WidgetSettings::find($this->chain);
        if($settings->w_let_check_steps) {
            unset($settings->w_steps_g);
        }else{
            unset($settings->w_steps_service);
            unset($settings->w_steps_employee);
        }
        return response()->json(["data"=>["settings"=>$settings]],200);
    }
}