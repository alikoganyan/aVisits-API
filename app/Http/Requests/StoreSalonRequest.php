<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'title' => 'required|max:255',
            "img" => "max:255",
            "city" => "max:255",
            "address" => "max:255",
            "latitude" => "between:0,99.99999999",
            "longitude" => "between:0,999.99999999",
            "chain_id" => "integer|max:10",
        ];
    }
}
