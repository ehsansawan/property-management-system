<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReportRequest extends FormRequest
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
            'ad_id'=>'required|exists:ads,id',
            'reason' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'sexual_content',
                    'harassment',
                    'spam',
                    'hate_speech',
                    'violence',
                    'scam',
                    'fake_information',
                    'other',
                ]),
            ],
            'description' => 'nullable|string',
        ];
    }
}
