<?php

namespace App\Services\Location;



use App\Models\Location;
use Illuminate\Support\Facades\Validator;

class LocationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
     $locations=Location::with('city.Governorate')->get();
     $message='locations retrieved successfully';
     $code=200;
     return ['locations'=>$locations,'message'=>$message,'code'=>$code];
    }

    public function show($id)
    {

        $location=Location::query()->find($id);
        if(!$location){
            $message='location not found';
            $code=404;
            return ['location'=>null,'message'=>$message,'code'=>$code];
         }
        $location['city']=$location->city->name;
        $location['governorate']=$location->city->governorate->name;

        $message='location retrieved successfully';
        $code=200;
        return ['location'=>$location,'message'=>$message,'code'=>$code];
    }
    public function create($request)
    {
       $valid=Validator::make($request->all(),[
           'city_id'=>'required|integer|exists:cities,id',
           'description'=>'required|string'
       ]);
       if($valid->fails()){
           return ['location'=>null,'message'=>$valid->errors(),'code'=>422];
       }
       $location=Location::query()->create([
           'city_id'=>$request['city_id'],
           'description'=>$request['description']
       ]);
       $message="Location created";
       $code=201;
       return ['location'=>$location,'message'=>$message,'code'=>$code];
    }
    public function update($request,$id)
    {
      $valid=Validator::make($request->all(),[
          'city_id'=>'integer|exists:cities,id',
          'description'=>'string'
      ]);
      if($valid->fails()){
          return ['location'=>null,'message'=>$valid->errors(),'code'=>422];
      }
      $location=Location::query()->find($id);
      if(!$location){
          return ['location'=>null,'message'=>'Location not found','code'=>404];
      }
      $location->city_id=$request['city_id']??$location->city_id;
      $location->description=$request['description']??$location->description;
      $location->save();
      $message="Location updated";
      $code=200;
      return ['location'=>$location,'message'=>$message,'code'=>$code];
    }
    public function delete($id)
    {
        $location=Location::query()->find($id);
        if(!$location){
            return ['location'=>null,'message'=>'Location not found','code'=>404];
        }
        $location->delete();
        $message="Location deleted";
        $code=200;
        return ['location'=>$location,'message'=>$message,'code'=>$code];

    }

}
