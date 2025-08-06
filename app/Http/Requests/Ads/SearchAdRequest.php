<?php

namespace App\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;

class SearchAdRequest extends FormRequest
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
        $rules = [
            'type' => 'sometimes|string|in:apartment,land,office,shop',
            'min_price'=>'numeric|nullable',
            'max_price'=>'numeric|nullable',
            'min_area'=>'numeric|nullable',
            'max_area'=>'numeric|nullable',
        ];

        if($this->filled('type')){

            switch ($this->get('type'))
            {
                case'apartment':
                    $rules=array_merge($rules,$this->getApartmentRules());
                    break;
                case'land':
                    $rules=array_merge($rules,$this->getLandRules());
                    break;
                case'office':
                    $rules=array_merge($rules,$this->getOfficesRules());
                    break;
                case'shop':
                    $rules=array_merge($rules,$this->getShopRules());
                    break;
            }

        }

        return $rules;
    }





protected function prepareForValidation()
{
    if($this->has('type'))
    {
        $this->merge(['type'=>strtolower($this->get('type'))]);
    }
}
protected function getApartmentRules(): array
{
    return (new SearchApartmentRequest())->rules();
}

protected function getLandRules(): array
{
    return (new SearchLandRequest())->rules();
}

protected function getShopRules(): array
{
    return (new SearchShopRequest())->rules();
}

protected function getOfficesRules(): array
{
    return (new SearchOfficeRequest())->rules();
}

}
