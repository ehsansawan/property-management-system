<?php

namespace App\Services\Location;

use App\Models\City;
use App\Models\Governorate;
use App\Models\SuggestedLocation;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class SuggestedLocationService
{
public function __contruct()
{

}

public function index()
{

}
public function userSuggestedLocations($request)
{
$user_id=$request['user_id']??auth('api')->id();
$user=User::query()->find($user_id);
if(!$user)
{
    $message="User not found";
    $code=404;
    return ['locations'=>null,'message'=>$message,'code'=>$code];
}

$locations=$user->suggestedLocations()->with('governorate')->orderBy('governorate_id')->get();
$message='user suggested locations list';
$code=200;
return ['locations'=>$locations,'message'=>$message,'code'=>$code];

}
public function suggestedLocationsByGovernorate($request)
{
    $governorate=Governorate::query()->find($request['governorate_id']??null);
    if(!$governorate)
    {
        $message="governorate not found";
        $code=404;
        return ['locations'=>null,'message'=>$message,'code'=>$code];
    }

    $locations=$governorate->suggestedLocations()->with('user')->orderBy('user_id')->get();
    $message='governorate suggested locations list';
    $code=200;
    return ['locations'=>$locations,'message'=>$message,'code'=>$code];
}
public function show($id)
{
    $location=SuggestedLocation::query()->find($id);
    if(!$location)
    {
        $message="the id not found";
        $code=404;
        return ['location'=>null,'message'=>$message,'code'=>$code];
    }
    $location=$location->with('user','governorate')->orderBy('user_id')->get();
    $message=' suggested location retrieved successfully';
    $code=200;
    return ['location'=>$location,'message'=>$message,'code'=>$code];
}
public function create($request)
{
 $user_id=$request['user_id']??auth('api')->id();


 $location=SuggestedLocation::query()->create([
     'user_id'=>$user_id,
     'governorate_id'=>$request['governorate_id'],
     'city_name'=>$request['city_name'],
    // 'description'=>$request['description'],
 ]);

 $message='Suggested location created successfully';
 $code=201;

 return ['location'=>$location,'message'=>$message,'code'=>$code];

}
public function update($request,$id)
{
$user_id=$request['user_id']??auth('api')->id();

$valid=Validator::make($request->all(),[
    'governorate_id'=>'exists:governorates,id',
    'city_name'=>'required',
  //  'description'=>'string',
]);


$location=SuggestedLocation::query()->find($id);

if(!$location)
{
    $message="suggested location not found";
    $code=404;
    return ['locations'=>null,'message'=>$message,'code'=>$code];
}


$location->Governorate_id=$request['governorate_id']??$location->Governorate_id;
$location->city_name=$request['city_name']??$location->description;

$location->save();
$message='Suggested location updated successfully';
$code=200;
return ['location'=>$location,'message'=>$message,'code'=>$code];

}
public function delete($id)
{
$location=SuggestedLocation::query()->find($id);
if(!$location)
{
    $message="suggested location not found";
    $code=404;
    return ['location'=>null,'message'=>$message,'code'=>$code];
}
$location->delete();
$message='Suggested location deleted successfully';
$code=200;
return ['location'=>$location,'message'=>$message,'code'=>$code];
}
public function approve($id)
{
 $location=SuggestedLocation::query()->find($id);

 if(!$location)
 {
     $message="suggested location not found";
     $code=404;
     return ['location'=>null,'message'=>$message,'code'=>$code];
 }

 $city=City::query()->where('name',$location->city_name)
     ->where('governorate_id',$location->governorate_id)->exists();

 if($city)
 {
     $location->delete();
     $message="city already exist";
     $code=200;
     return ['location'=>$location,'message'=>$message,'code'=>$code];
 }


     City::query()->create([
         'name'=>$location->city_name,
         'governorate_id'=>$location->governorate_id,
     ]);

 $location->delete();

 $message='city is added successfully';
 $code=200;

 return ['location'=>$city,'message'=>$message,'code'=>$code];

}

}
