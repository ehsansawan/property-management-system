<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class CreateShopRequest extends FormRequest
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
            'data.floor'=>'required|integer',
            'data.type'=>'required|string|in:retail,grocery,pharmacy,bookstore,restaurant,salon,other',
            'data.has_warehouse'=>'boolean',
            'data.has_bathroom'=>'boolean',
            'data.has_ac'=>'boolean',
           // 'data.is_ready'=>'boolean',
        ];
    }
}
