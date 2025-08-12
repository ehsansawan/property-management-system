<?php

namespace App\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;

class SearchApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'data.min_floor'=>'integer',
            'data.max_floor'=>'integer',
            'data.min_rooms'=>'integer',
            'data.max_rooms'=>'integer',
            'data.min_bathrooms'=>'integer',
            'data.min_bedrooms'=>'integer',
            'data.has_elevator'=>'boolean',
            'data.has_alternative_power'=>'boolean',
            'data.has_garage'=>'boolean',
            'data.furnished'=>'boolean',
            'data.furnished_type'=>'string|in:economic,standard,delux,super_delux,luxury',
        ];
    }


}
