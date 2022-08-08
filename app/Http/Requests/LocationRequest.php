<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
            'location_id'       => 'nullable|integer|not_in:' . ($this->id ?? null),
            'address'           => 'nullable|max:255',
            'address_secondary' => 'nullable|max:255',
            'city'              => 'nullable|max:255',
            'state'             => 'nullable|max:255',
            'country'           => 'nullable|max:255',
            'zipcode'           => 'nullable|max:255',
            'latitude'          => 'nullable|max:255',
            'longitude'         => 'nullable|max:255',
        ];
    }
}
