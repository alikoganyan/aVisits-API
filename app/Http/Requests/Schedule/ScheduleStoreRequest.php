<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "salon_id"=>"required|integer|max:9999999999",
            "employee_id"=>"required|integer|max:9999999999",
            "start_time"=>"required|date_format:H:i",
            "end_time"=>"required|date_format:H:i",
            "dat"=>"string",
            "working_status"=>"integer|max:1"
        ];
    }
}
