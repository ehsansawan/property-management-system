<?php

namespace App\Services\Property;

use App\Models\User;

class PropertyService
{
    public function __construct()
    {

    }
    public function getPropertiesList($id)
    {
        $user=User::query()->find($id);
        if(!$user)
        {
            $message="User not found";
            $code=404;
            return ['properties'=>null,'message'=>$message,'code'=>$code];
        }
        $properties=$user->properties;

        return['properties'=>$properties,'message'=>'properties retrieved successfully','code'=>200];
    }
}
