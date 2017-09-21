<?php

namespace App\Http\Requests\SalonSchedule;

use Illuminate\Foundation\Http\FormRequest;

class SalonScheduleStoreRequest extends FormRequest
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
            "salon_id"=>"required|exists:salons,id",
            "start"=>"",
            "end"=>"",
            "num_of_day"=>"",
            "working_status"=>"integer|max:3"
        ];
    }
}
