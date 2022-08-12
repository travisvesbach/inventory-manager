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
            'location_id'       => 'integer',
            'acquisition_date'  => 'date',
            'acquisition_price' => 'decimal',
            'disposition_date'  => 'date',
            'disposition_price' => 'decimal',
            'info_url'          => 'max:255',
        ];
    }
}
