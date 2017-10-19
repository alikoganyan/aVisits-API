<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreSalonRequest extends FormRequest
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
        $rules=[
            'title' => 'required|max:255',
            "img" => "max:255",
            "city" => "max:255",
            "address" => "max:255",
            "latitude" => "between:0,99.99999999",
            "longitude" => "between:0,999.99999999",
            "chain_id" => "integer|max:10",
        ];
        for($i=1;$i<=7;$i++) {
            $rules['schedule['.$i.'][num_of_day]']='required|integer|between:1,7';
            $rules['schedule['.$i.'][working_status]']='required|integer|between:0,1';
            $rules['schedule['.$i.'][start]']='required|date_format:H:i';
            $rules['schedule['.$i.'][end]']='required|date_format:H:i';
        }
        return $rules;
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['ValidationError' => $validator->messages()]));
    }
}
