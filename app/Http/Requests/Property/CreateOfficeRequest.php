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
            'data.floor'=>'required|integer',
            'data.rooms'=>'required|integer',
            'data.bathrooms'=>'required|integer',
            'data.meeting_rooms'=>'integer',
            'data.has_parking'=>'boolean',
            'data.furnished'=>'required|boolean',
            'data.furnished_type'=>'nullable|string|in:economic,standard,delux,super_delux,luxury',
        ];
    }
}
