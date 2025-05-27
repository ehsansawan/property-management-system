<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class CreateApartmentRequest extends FormRequest
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
            //
            'Apartment.floor'=>'integer|required',
            'Apartment.rooms'=>'integer|required',
            'Apartment.bathrooms'=>'integer|required',
            'Apartment.bedrooms'=>'integer|required',
            'Apartment.has_elevator'=>'boolean',
            'Apartment.has_alternative_power'=>'boolean',
            'Apartment.has_garage'=>'boolean',
            'Apartment.furnished'=>'boolean',
            'Apartment.furnished_type'=>'string|required',
        ];
    }
}
