<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
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
        $rules= [

            //
            'type' => 'required|string|in:apartment,land,office,shop',
            'property.area'=>'numeric',
            'property.name'=>'string',
            'property.description'=>'string',
            'property.price'=>'numeric',
            'property.image'       => 'sometimes|array',
            'property.image.*'     => ['file'=>'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'property.image_to_delete'=>'sometimes|array',
            'property.image_to_delete.*'=>'nullable|integer|exists:images,id',
            'property.latitude'     => 'nullable|numeric|between:-90,90',
            'property.longitude'    => 'nullable|numeric|between:-180,180',
            'property.address'      => 'string|nullable',
            //'property.title'=>'string',
        ];
        switch ($this->input('type'))
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
        return (new UpdateApartmentRequest())->rules();
    }

    protected function getLandRules(): array
    {
        return (new UpdateLandRequest())->rules();
    }

    protected function getShopRules(): array
    {
        return (new UpdateShopRequest())->rules();
    }

    protected function getOfficesRules(): array
    {
        return (new UpdateOfficeRequest())->rules();
    }

}
