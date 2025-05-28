<?php

namespace App\Http\Requests\Profle;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfileRequest extends FormRequest
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
            'first_name' => 'string|max:255',
            'last_name' => '|string|max:255',
            'phone_number' => 'required|regex:/^09\d{8}$/',//|unique:users,phone_number
            'image_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'nullable|string|in:male,female',
        ];
    }
}
