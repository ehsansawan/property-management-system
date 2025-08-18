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
            'furnished_type'=>'nullable|string|in:economic,standard,delux,super_delux,luxury',
        ];

        return ['attributes'=>$attributes];
    }
    public function search($query,$request)
    {
        $query=$query->join('apartments','properties.propertyable_id','=','apartments.id')
            ->where('properties.propertyable_type',\App\Models\Apartment::class);

        if (isset($request['min_floor'])) {
            $query->where('apartments.floor', '>=', $request['min_floor']);
        }
        if (isset($request['max_floor'])) {
            $query->where('apartments.floor', '<=', $request['max_floor']);
        }
        if(isset($request['min_rooms'])){
            $query->where('apartments.rooms', '>=', $request['min_rooms']);
        }
        if (isset($request['max_rooms'])) {
            $query->where('apartments.rooms', '<=', $request['max_rooms']);
        }
        if(isset($request['min_bathrooms']))
        {
            $query->where('apartments.bathrooms','>=',$request['min_bathrooms']);
        }
        if (isset($request['min_bedrooms']))
        {
            $query->where('apartments.bedrooms','>=',$request['min_bedrooms']);
        }
        if(isset($request['has_alternative_power']) && $request['has_alternative_power'] )
        {
            $query->where('apartments.has_alternative_power',true);
        }
        if(isset($request['has_garage']) && $request['has_garage'] )
        {
            $query->where('apartments.has_garage',true);
        }
        if(isset($request['has_elevator']) && $request['has_elevator'] )
        {
            $query->where('apartments.has_elevator',true);
        }
        if(isset($request['furnished']) && $request['furnished'] )
        {
            $query->where('apartments.furnished',true);
        }
        if (!empty($request['furnished_type'])) {
            if (is_array($request['furnished_type'])) {
                $query->whereIn('apartments.furnished_type', $request['furnished_type']);
            } else {
                $query->where('apartments.furnished_type', $request['furnished_type']);
            }
        }



        //difference between !empty and isset
        //isset return 1 if u put a 0
        //empty consider 0 as an empty value
        //u can use !empty($request['has_***]) instead of isset($request['has_alternative_power']) && $request['has_alternative_power']

        return $query;

    }
    public function similarTo($ad):array
    {
        // Floors
        $request['min_floor'] = isset($ad['floor']) ? max($ad['floor'] - 1, 0) : null;
        $request['max_floor'] = isset($ad['floor']) ? $ad['floor'] + 1 : null;

// Rooms
        $request['min_rooms'] = isset($ad['rooms']) ? max($ad['rooms'] - 1, 0) : null;
        $request['max_rooms'] = isset($ad['rooms']) ? $ad['rooms'] + 1 : null;

// Bathrooms
        $request['min_bathrooms'] = isset($ad['bathrooms']) ? max($ad['bathrooms'] - 1, 0) : null;

// Bedrooms
        $request['min_bedrooms'] = isset($ad['bedrooms']) ? max($ad['bedrooms'] - 1, 0) : null;

// Booleans (direct equality)
        $request['has_alternative_power'] = $ad['has_alternative_power'] ?? null;
        $request['has_garage']            = $ad['has_garage'] ?? null;
        $request['has_elevator']          = $ad['has_elevator'] ?? null;
        $request['furnished']             = $ad['furnished'] ?? null;

// Furnished type (string/array)
        $request['furnished_type'] = $ad['furnished_type'] ?? null;

        return $request;

    }




}
