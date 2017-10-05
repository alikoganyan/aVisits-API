<?php

namespace App\Http\Requests\ServicePrice;

use Illuminate\Foundation\Http\FormRequest;

class ServicePriceStoreRequest extends FormRequest
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
            'price_level_id'=>'required|exists:price_levels,id',
            'service_id'=>'required|exists:services,id',
            "price"=>"between:0,999999.99",
            "from"=>"date_format:Y-m-d"
        ];
    }
}
