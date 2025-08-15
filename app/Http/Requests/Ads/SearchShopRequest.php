<?php

namespace App\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;

class SearchShopRequest extends FormRequest
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
         //   'data.floor'=>'integer',
            'data.type'=>'sometimes|array',
            'data.type.*'=>'string|in:retail,grocery,pharmacy,bookstore,restaurant,salon,other',
            'data.has_warehouse'=>'boolean',
            'data.has_bathroom'=>'boolean',
            'data.has_ac'=>'boolean',
        ];
    }
}
