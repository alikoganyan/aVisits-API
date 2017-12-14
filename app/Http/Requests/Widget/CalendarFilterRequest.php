<?php

namespace App\Http\Requests\Widget;

use Illuminate\Foundation\Http\FormRequest;

class CalendarFilterRequest extends FormRequest
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
            "employees"=>"required|array",
            "from"=>"required|date_format:Y-m-d",
            "to"=>"required|date_format:Y-m-d"
        ];
    }
}
