<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class CreatePropertyRequest extends FormRequest
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
            //
            'type' => 'required|string|in:apartment,land,office,shop',
            'property.user_id'     => 'integer|exists:users,id',
       //   'property.location_id' => 'required|integer|exists:locations,id',
            'property.area'        => 'numeric|nullable',
            'property.name'        => 'string|nullable',
            'property.description' => 'string|nullable',
            'property.price'       => 'numeric|nullable',
            'property.image'       => 'sometimes|array',
            'property.image.*'     => ['file'=>'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'property.latitude'     => 'nullable|numeric|between:-90,90',
            'property.longitude'    => 'nullable|numeric|between:-180,180',
            'property.address'      => 'string|nullable',
        ];

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
        return (new CreateApartmentRequest())->rules();
    }

        protected function getLandRules(): array
    {
        return (new CreateLandRequest())->rules();
    }

        protected function getShopRules(): array
        {
            return (new CreateShopRequest())->rules();
        }

        protected function getOfficesRules(): array
        {
            return (new CreateOfficeRequest())->rules();
        }


}
