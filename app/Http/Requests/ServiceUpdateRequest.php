<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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
            "service_category_id"=>"exists:service_categories,id",
            "title"=>"string|max:255",
            "description"=>"string|max:255",
            "duration"=>"integer",
            "price"=>"between:0,999999.99"
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return parent::messages(); // TODO: Change the autogenerated stub
    }
}
