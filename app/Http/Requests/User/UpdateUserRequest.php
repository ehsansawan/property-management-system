<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'string|max:255',
            //'email' => 'string|email|max:255|unique:users',
//            'email' => [
//                            'email', 'min:6', 'max:50', 'string',
//                            Rule::unique('users', 'email')->ignore($this->route('id')),
//                        ],
            'password' => 'string|min:8|confirmed',
            'phone_number' => 'regex:/^09\d{8}$/',//|unique:users,phone_number
        ];
    }
}
