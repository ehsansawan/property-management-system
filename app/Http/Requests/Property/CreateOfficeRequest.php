<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class CreateOfficeRequest extends FormRequest
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
            'Office.floor'=>'required|integer',
            'Office.rooms'=>'required|integer',
            'Office.bathrooms'=>'required|integer',
            'Office.meeting_rooms'=>'integer',
            'Office.has_parking'=>'boolean',
            'Office.furnished'=>'required|boolean',
            'Office.furnished_type'=>'string'
        ];
    }
}
