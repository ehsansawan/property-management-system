<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use App\Traits\PictureTrait;

class ProfileService
{
    use PictureTrait;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function show($request):array
    {
        $user_id=$request['user_id']??auth('api')->id();
        $user=User::query()->with('profile')->find($user_id);

        if(!$user){
            $message='user not found';
            $code=404;
            return ['profile'=>$user,'message'=>$message,'code'=>$code];
        }

        $profile=$user->profile;
            //Profile::query()->where('user_id',$id)->first();

        if(!$profile)
        {
            $message="you haven't created a profile yet";
            $code=404;
            return["profile"=>$user,"message"=>$message,"code"=>$code];
        }

        $message="profile retrieved successfully";
        $code=200;
        return["profile"=>$user,"message"=>$message,"code"=>$code];

    }
    public function create($request):array
    {
        $user=User::query()->find(auth('api')->id());

        if(!$user)
        {
            $message="there is no user to create profile";
            $code=404;
            return ['profile'=>null,'message'=>$message,'code'=>$code];
        }

        $profile=$user->profile;
       // $profile= Profile::query()->where('user_id',auth('api')->id())->first();

        if($profile)
        {
            $message="you have already created a profile";
            $code=500;
            return["profile"=>$user,"message"=>$message,"code"=>$code];
        }


        $data=collect($request);
        if($data->get('image_url')!=null)
        $file_url=$this->StorePicture($data->get('image_url'),'uploads\Profile');

        $profile=Profile::query()->create(
            [
                "user_id"=>auth('api')->id(),
                "first_name"=>$data->get('first_name'),
                "last_name"=>$data->get('last_name'),
                "phone_number"=>$data->get('phone_number'),
                "image_url"=>$file_url??null,
                "gender"=>$data->get('gender'),
            ]
        );
        if(!$profile)
        {
            $message="something went wrong,try again later";
            $code=500;
            return["profile"=>$user,"message"=>$message,"code"=>$code];
        }

        $user=User::query()->with('profile')->find(auth('api')->id());
        $message="profile created successfully";
        $code=200;
        return["profile"=>$user,"message"=>$message,"code"=>$code];

    }
    public function update($request):array
    {

        $data=collect($request);


        $user_id=$request['user_id']??auth('api')->id();

        $user=User::query()->find($user_id);

        if(!$user)
        {
            $message="user not found";
            $code=404;
            return["profile"=>null,"message"=>$message,"code"=>$code];
        }



        $profile=$user->profile;
        //$profile=Profile::query()->where('user_id',$id)->first();

        if(!$profile)
        {
            $message="you haven't created a profile yet";
            $code=404;
            return["profile"=>$user,"message"=>$message,"code"=>$code];
        }


        $fields = ['first_name', 'last_name', 'phone_number', 'gender'];

        foreach ($fields as $field) {
            if (filled($data->get($field))) {
                $profile->{$field} = $data->get($field);
            }
        }

        if($data->get('image_url')!= null)
        {
            $file_url=$this->StorePicture($data->get('image_url'),'uploads/Profile');
            $this->destroyPicture($profile->image_url);
        }

       $profile->image_url=$file_url??$profile->image_url;

        $profile->save();
        $user=User::query()->with('profile')->find(auth('api')->id());
        $message="profile updated successfully";
        $code=200;

        return["profile"=>$user,"message"=>$message,"code"=>$code];

    }
    public function delete($request):array
    {

        $user_id=$request['user_id']??auth('api')->id();
        $user=User::query()->find($user_id);

        if(!$user)
        {
            $message="user not found";
            $code=404;
            return["profile"=>null,"message"=>$message,"code"=>$code];
        }

        $profile=$user->profile;
        //$profile=Profile::query()->where('user_id',$id)->first();
        if(!$profile)
        {
            $message="profile not found";
            $code=404;
            return["profile"=>$profile,"message"=>$message,"code"=>$code];
        }

        $this->destroyPicture($profile->image_url);
        $profile->delete();
        $message="profile deleted successfully";
        $code=200;
        return["profile"=>$profile,"message"=>$message,"code"=>$code];

    }



}
