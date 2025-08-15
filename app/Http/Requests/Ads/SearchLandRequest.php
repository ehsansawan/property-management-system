<?php

namespace App\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;

class SearchLandRequest extends FormRequest
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
            'data.LandType'=>'sometimes|array',
            'data.LandType.*'=>'string|in:industrial,agricultural,commercial,residential',
            'data.is_inside_master_plan'=>'boolean',
            'data.is_serviced'=>'boolean',
            'data.slope'=>'sometimes|array',
            'data.slope.*'=>'nullable|string|in:flat,sloped,mountainous'
        ];
    }
}
