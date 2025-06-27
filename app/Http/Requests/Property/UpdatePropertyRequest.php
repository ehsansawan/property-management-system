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
            'type' => 'required|string|in:Apartment,Land,Office,Shop',
            'property.area'=>'numeric',
            'property.name'=>'string',
            'property.description'=>'string',
            'property.price'=>'numeric',
            'property.image'       => 'sometimes|array',
            'property.image.*'     => ['file'=>'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'property.image_to_delete'=>'sometimes|array',
            'property.image_to_delete.*'=>'nullable|integer|exists:images,id',
            //'property.title'=>'string',
        ];
        switch ($this->input('type'))
        {
            case'Apartment':
                $rules=array_merge($rules,$this->getApartmentRules());
                break;
            case'Land':
                $rules=array_merge($rules,$this->getLandRules());
                break;
            case'Office':
                $rules=array_merge($rules,$this->getOfficesRules());
                break;
            case'Shop':
                $rules=array_merge($rules,$this->getShopRules());
                break;
        }


        return $rules;
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
