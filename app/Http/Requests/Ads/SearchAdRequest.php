<?php

namespace App\Http\Requests\Ads;

use App\Rules\MinLessThanMax;
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
            'min_price' => [
                'nullable',
                'numeric',
                'less_than_field:max_price',
            ],
            'max_price'=>'numeric|nullable',
            'min_area'=>[
                'numeric'
                ,'nullable'
                ,'less_than_field:max_area'
            ],
            'max_area'=>'numeric|nullable',
            'num'=>'integer|nullable',
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
//    public function withValidator($validator)
//    {
//        $validator->after(function ($validator) {
//            $min = $this->input('min_price');
//            $max = $this->input('max_price');
//
//            // إذا الحقلين موجودين
//            if (!is_null($min) && !is_null($max) && $min > $max) {
//                $validator->errors()->add('min_price', 'min price should be less than max price');
//            }
//        });
//        $validator->after(function ($validator) {
//
//            $min = $this->input('min_area');
//            $max = $this->input('max_area');
//
//            // إذا الحقلين موجودين
//            if (!is_null($min) && !is_null($max) && $min > $max) {
//                $validator->errors()->add('min_area', 'min area should be less than max price');
//            }
//        });
//
//        $validator->after(function ($validator) {
//            $min = $this->input('data.min_floor');
//            $max = $this->input('data.max_floor');
//
//
//            // إذا الحقلين موجودين
//            if (!is_null($min) && !is_null($max) && $min > $max) {
//                $validator->errors()->add('data.min_floor', 'min floor should be less than max floor');
//            }
//        });
//        $validator->after(function ($validator) {
//            $min = $this->input('data.min_rooms');
//            $max = $this->input('data.max_rooms');
//
//            // إذا الحقلين موجودين
//            if (!is_null($min) && !is_null($max) && $min > $max) {
//                $validator->errors()->add('data.min_rooms', 'min rooms should be less than max rooms');
//            }
//        });
//    }
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
