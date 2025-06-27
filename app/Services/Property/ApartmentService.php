<?php

namespace App\Services\Property;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApartmentService
{

    public function __construct()
    {

    }
    public function getApartmentsList($user_id)
    {
       $user=User::query()->find($user_id);

//       $apartments=$user->properties()->where('property_type',\App\Models\Apartment::class)->
//       with('propertyable')->get();


        $apartments=$user->apartments()->with('propertyable')->get();
       // with for loading apartments data without it, it will put only the property data


       $message="apartments retrieved successfully";
       $code=200;
       return ['apartments'=>$apartments,'message'=>$message,'code'=>$code];
    }
    public function getApartment($id)
    {
        $apartment=Apartment::query()->with('property')->find($id);


        $message="apartment retrieved successfully";
        $code=200;
        return ['apartment'=>$apartment,'message'=>$message,'code'=>$code];

    }
    public function create($request)
    {
        $data=collect($request->get('data'));


            $apartment=Apartment::query()->create(
                [
                    'floor'=>$data->get('floor'),
                    'rooms'=>$data->get('rooms'),
                    'bedrooms'=>$data->get('bedrooms'),
                    'bathrooms'=>$data->get('bathrooms'),
                    'has_garage'=>$data->get('has_garage')??false,
                    'has_elevator'=>$data->get('has_elevator')??false,
                    'has_alternative_power'=>$data->get('has_alternative_power')??false,
                    'furnished'=>$data->get('furnished')??false,
                    'furnished_type'=>$data->get('furnished_type'),
                ]
            );
            $message="apartment created successfully";
            $code=201;
            return ['apartment'=>$apartment,'message'=>$message,'code'=>$code];
    }
    public function update($request,$id)
    {
       $data=collect($request->get('data'));
       $apartment=Apartment::query()->find($id);


        $fields = [  'floor','rooms','bedrooms','bathrooms','has_elevator','has_garage','furnished',
            'furnished_type','has_alternative_power'];

        foreach ($fields as $field) {
            if (filled($data->get($field))) {
                $apartment->{$field} = $data->get($field);
            }
        }

        $apartment->save();

        $message="apartment updated successfully";
        $code=200;
        return ['apartment'=>$apartment,'message'=>$message,'code'=>$code];

    }
    public function delete($id)
    {
        $apartment=Apartment::query()->find($id);

        $apartment->delete();
        $message="apartment deleted successfully";
        $code=200;
          return ['apartment'=>$apartment,'message'=>$message,'code'=>$code];
    }
    public function getAttributes()
    {
        $attributes=[
            'floor'=>'integer|required',
            'rooms'=>'integer|required',
            'bathrooms'=>'integer|required',
            'bedrooms'=>'integer|required',
            'has_elevator'=>'boolean',
            'has_alternative_power'=>'boolean',
            'has_garage'=>'boolean',
            'furnished'=>'boolean',
            'data.furnished_type'=>'nullable|string|in:economic,standard,delux,super_delux,luxury',
        ];

        return ['attributes'=>$attributes];
    }




}
