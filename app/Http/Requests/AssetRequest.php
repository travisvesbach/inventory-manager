<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
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
            'name'              => 'required|max:255',
            'category_id'       => 'required|integer',
            'location_id'       => 'nullable|integer',
            'acquisition_date'  => 'nullable|date',
            'acquisition_price' => 'nullable|numeric|between:0,999999.99',
            'disposition_date'  => 'nullable|date',
            'disposition_price' => 'nullable|numeric|between:0,999999.99',
            'info_url'          => 'max:255',
            'notes'             => '',
        ];
    }
}
