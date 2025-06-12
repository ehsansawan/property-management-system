<?php

namespace App\Services\Location;

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
public function userSuggestedLocations($user_id)
{
$user=User::query()->find($user_id);
if(!$user)
{
    $message="User not found";
    $code=404;
    return ['locations'=>null,'message'=>$message,'code'=>$code];
}

$locations=$user->suggestedLocations()->get();
$message='user suggested locations list';
$code=200;
return ['locations'=>$locations,'message'=>$message,'code'=>$code];

}
public function suggestedLocationsByGovernorate($governorate_id)
{
    $governorate=Governorate::query()->find($governorate_id);
    if(!$governorate)
    {
        $message="User not found";
        $code=404;
        return ['locations'=>null,'message'=>$message,'code'=>$code];
    }

    $locations=$governorate->suggestedLocations()->get();
    $message='governorate suggested locations list';
    $code=200;
    return ['locations'=>$locations,'message'=>$message,'code'=>$code];
}

public function create($request)
{
 $user_id=$request['user_id']??auth('api')->id();

 $location=SuggestedLocation::query()->create([
     'user_id'=>$user_id,
     'governorate_id'=>$request['governorate_id'],
     'description'=>$request['description'],
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
    'description'=>'string',
]);


$location=SuggestedLocation::query()->find($id);

if(!$location)
{
    $message="suggested location not found";
    $code=404;
    return ['locations'=>null,'message'=>$message,'code'=>$code];
}


$location->Governorate_id=$request['governorate_id']??$location->Governorate_id;
$location->description=$request['description']??$location->description;

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
    return ['locations'=>null,'message'=>$message,'code'=>$code];
}
$location->delete();
$message='Suggested location deleted successfully';
$code=200;
return ['location'=>$location,'message'=>$message,'code'=>$code];
}

}
