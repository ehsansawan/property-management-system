<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
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
            'data.floor'=>'integer',
            'data.rooms'=>'integer',
            'data.bathrooms'=>'integer',
            'data.bedrooms'=>'integer',
            'data.has_elevator'=>'boolean',
            'data.has_alternative_power'=>'boolean',
            'data.has_garage'=>'boolean',
            'data.furnished'=>'boolean',
            'data.furnished_type'=>'string|required',
        ];
    }
}
