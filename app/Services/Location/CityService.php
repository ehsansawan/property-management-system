<?php

namespace App\Services\Location;


use App\Models\City;
use App\Models\Governorate;
use Illuminate\Support\Facades\Validator;

class CityService
{

    public function __construct()
    {
        //
    }
    public function show($id)
    {
        $city=City::query()->find($id);
        if(!$city){
            $message="City not found";
            $code=404;
            return ['city'=>null,'message'=>$message,'code'=>$code];
        }

        $message='city retrieved successfully';
        $code=200;
         return ['city'=>$city,'message'=>$message,'code'=>$code];
    }
    public function getCitiesByGovernorate($governorate_id)
    {

        $governorate = Governorate::find($governorate_id);

        if(!$governorate){
            $message='not_found';
            $code=404;
            return ['cities'=>null,'message'=>$message,'code'=>$code];
        }
        $cities = $governorate->cities;
        $message='cities retrieved successfully';
        $code=200;
        return ['cities'=>$cities,'message'=>$message,'code'=>$code];
    }
    public function create($request)
    {

        $valid=Validator::make($request->all(),[
            'name'=>'required|string|unique:cities,name',
            'governorate_id'=>'required|exists:governorates,id'
        ]);
        if($valid->fails())
        {
            return ['city'=>null,'message'=>$valid->errors(),'code'=>422];
        }

        $city=City::query()->create([
            'name'=>$request->name,
            'governorate_id'=>$request->governorate_id
        ]);
        $message="City created successfully";
        $code=201;
        return ['city'=>$city,'message'=>$message,'code'=>$code];
    }
    public function update($request,$id)
    {
        $city=City::query()->find($id);
        if(!$city)
        {
            return ['city'=>null,'message'=>'Governor not found','code'=>404];
        }
        $valid=Validator::make($request->all(),['name'=>'required|string|unique:cities,name',
        'governorate_id'=>'required|exists:governorates,id']);
        if($valid->fails())
        {
            return ['city'=>null,'message'=>$valid->errors(),'code'=>422];
        }

        if($request->name!=$city->name)
            $city->name=$request->name;
        if($request->governorate_id!=$city->governorate_id)
            $city->governorate_id=$request->governorate_id;

        $city->save();
        $message="City updated successfully";
        $code=200;
        return ['city'=>$city,'message'=>$message,'code'=>$code];
    }
    public function delete($id)
    {
        $city=City::query()->find($id);
        if(!$city)
            return ['city'=>null,'message'=>'Governor not found','code'=>404];

        $city->delete();
        $message="City deleted successfully";
        $code=200;
        return ['city'=>$city,'message'=>$message,'code'=>$code];
    }
}
