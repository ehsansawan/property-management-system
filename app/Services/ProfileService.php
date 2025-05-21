<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function show($id):array
    {
        $profile=Profile::query()->find($id);

        if(!$profile)
        {
            $message="you haven't created a profile yet";
            $code=404;
            return["profile"=>$profile,"message"=>$message,"code"=>$code];
        }

        $message="profile retrieved successfully";
        $code=200;
        return["profile"=>$profile,"message"=>$message,"code"=>$code];

    }

    public function create($request):array
    {
        $data=collect($request);
        $profile=Profile::query()->create(
            [
                "user_id"=>auth('api')->id(),
                "first_name"=>$data->get('first_name'),
                "last_name"=>$data->get('last_name'),
                "phone_number"=>$data->get('phone_number'),
                "image_url"=>$data->get('image_url'),
                "gender"=>$data->get('gender'),
            ]
        );
        if(!$profile)
        {
            $message="something went wrong,try again later";
            $code=500;
            return["profile"=>$profile,"message"=>$message,"code"=>$code];
        }

        $message="profile created successfully";
        $code=200;
        return["profile"=>$profile,"message"=>$message,"code"=>$code];

    }
    public function update($request,$id):array
    {
        $data=collect($request);
        $profile=Profile::query()->find($id);

        if(!$profile)
        {
            $message="you haven't created a profile yet";
            $code=404;
            return["profile"=>$profile,"message"=>$message,"code"=>$code];
        }

        if(filled($data->get('first_name')))
        {
            $profile->first_name=$data->get('first_name');
        }
        if(filled($data->get('last_name')))
        {
            $profile->last_name=$data->get('last_name');
        }
        if(filled($data->get('phone_number')))
        {
            $profile->phone_number=$data->get('phone_number');
        }
        if(filled($data->get('image_url')))
        {
            $profile->image_url=$data->get('image_url');
        }
        if(filled($data->get('gender')))
        {
            $profile->gender=$data->get('gender');
        }
        $profile->save();
        $message="profile updated successfully";
        $code=200;

        return["profile"=>$profile,"message"=>$message,"code"=>$code];

    }
    public function delete($id):array
    {
        $profile=Profile::query()->find($id);
        if(!$profile)
        {
            $message="profile not found";
            $code=404;
            return["profile"=>$profile,"message"=>$message,"code"=>$code];
        }

        $profile->delete();
        $message="profile deleted successfully";
        $code=200;
        return["profile"=>$profile,"message"=>$message,"code"=>$code];

    }



}
