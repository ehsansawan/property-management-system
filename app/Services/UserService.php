<?php

namespace App\Services;

use App\Mail\SendCodeResetPassword;
use App\Models\Profile;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function get_users():array
    {
        $users=User::all();
        $message='users retrieved successfully';
        $code=200;
        return ['users'=>$users,'message'=>$message,'code'=>$code];
    }
    public function show($id):array
    {
        $user=User::query()->find($id);

        if(is_null($user))
        {
            $message='user not found';
            $code=404;
            return ['user'=>$user,'message'=>$message,'code'=>$code];
        }

        $message='user retrieved successfully';
        $code=200;
        return ['user'=>$user,'message'=>$message,'code'=>$code];
    }
    public function create($request):array
    {
        $data=new Request($request);

        $user=User::query()->create(
            [
                'first_name'=>$data->first_name,
                'last_name'=>$data->last_name,
                'email'=>$data->email,
                'password'=>bcrypt($data->password),
                'phone_number'=>$data->phone_number,
                'fcm_token'=>$data->fcm_token,
                //role_id
            ]
        );

        if(is_null($user))
        {
            $message='user can not be created, try again later';
            $code=400;
            return ['user'=>$user,'message'=>$message,'code'=>$code];
        }
        $message='user created successfully';
        $code=200;
        return ['user'=>$user,'message'=>$message,'code'=>$code];

    }
    public function update($request,$id):array
    {
        $user = User::query()->find($id);

        // very important casting from array to Request
        $data= new Request($request);

        if (is_null($user)) {
            $message = 'user not found';
            $code = 404;
            return ['user' => $user, 'message' => $message, 'code' => $code];
        }

        if ($data->filled('first_name')) {
            $user->first_name = $data->first_name;
        }
        if ($data->filled('last_name')) {
            $user->last_name = $data->last_name;
        }
        if ($data->filled('email')) {
            $user->email = $data->email;
        }
        if ($data->filled('phone')) {
            $user->phone = $data->phone;
        }
        if ($data->filled('password'))
        {
            $user->password = bcrypt($data->password);
        }

        $user->save();
        $message = 'user updated successfully';
        $code=200;
        return ['user'=>$user,'message'=>$message,'code'=>$code];

    }
    public function delete($id):array
    {
        $user=User::query()->find($id);

        if (is_null($user)) {
            $message = 'user not found';
            $code = 404;
            return ['user' => $user, 'message' => $message, 'code' => $code];
        }

        $user->delete();
        $message = 'user deleted successfully';
        $code=200;
        return ['user'=>$user,'message'=>'user deleted successfully','code'=>$code];
    }
    public function ForgetPassword(Request $request):array
    {
        $input=$request->validate([
            'email'=>'required|email|exists:users,email',
        ]);

        //Delete all old code that user send before
        ResetCodePassword::query()->where('email','=',$input['email'])->delete();

        //Generate random code
        $input['code']=mt_rand(100000,999999);

        //create a new code
        ResetCodePassword::query()->create([
           'email'=>$input['email'],
           'code'=>$input['code'],
        ]);

        //send email to user
        Mail::to($input['email'])->send(new SendCodeResetPassword($input['code']));

        $message='we send you an email,check your mails';
        $code=200;

        return ['info'=>$input,'message'=>$message,'code'=>$code];
    }
    public function CheckCode(Request $request):array
    {
        $input=$request->validate([
            'code'=>'required|string|exists:reset_code_passwords,code',
        ]);

        //find the code
        $passwordReset=ResetCodePassword::query()->where('code','=',$input['code'])->first();
        //check if the code expired
        if($passwordReset['created_at'] > now()->addHour())
        {
            $passwordReset->delete();
            $message='code has expired';
            $code=400;
            return ['info'=>$input,'message'=>$message,'code'=>$code];
        }

        $message='code is valid';
        $code=200;
        return ['info'=>$input,'message'=>$message,'code'=>$code];

    }
    public function ResetPassword(Request $request):array
    {
       $input=$request->validate([
           'code'=>'required|string|exists:reset_code_passwords,code',
           'password'=>'required|string|confirmed',
       ]);
       //find the code
        $passwordReset=ResetCodePassword::query()->where('code','=',$input['code'])->first();
       //check if the code expired
        $passwordReset=ResetCodePassword::query()->where('code','=',$input['code'])->first();
        if($passwordReset['created_at'] > now()->addHour())
        {
            $passwordReset->delete();
            $message='code has expired';
            $code=400;
            return ['info'=>$input,'message'=>$message,'code'=>$code];
        }

        $user=User::query()->where('email','=',$passwordReset['email'])->first();

        //remember to check if the user exists
        if(!$user)
        {
            $message='email not found';
            $code=404;
            return ['info'=>$input,'message'=>$message,'code'=>$code];
        }

        // update user password
        $user->update(['password'=>bcrypt($input['password'])]);

        //delete current code
        $passwordReset->delete();

        $message='password reset successfully';
        $code=200;
        return ['info'=>$input,'message'=>$message,'code'=>$code];


    }


}
