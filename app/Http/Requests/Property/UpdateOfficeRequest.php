<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'Office.floor'=>'integer',
            'Office.rooms'=>'integer',
            'Office.bathrooms'=>'integer',
            'Office.meeting_rooms'=>'integer',
            'Office.has_parking'=>'boolean',
            'Office.furnished'=>'boolean',
            'Office.furnished_type'=>'string'
        ];
    }
}
