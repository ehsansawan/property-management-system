<?php

namespace App\Services;


use App\Mail\SendCodeResetPassword;
use App\Models\Profile;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;




class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function register($request):array
    {

        $user=User::query()->create([
            'first_name'=>$request['first_name']??null,
            'last_name'=>$request['last_name']??null,
            'email'=>$request['email'],
            'password'=>Hash::make($request['password']),
            'phone_number'=>$request['phone_number'],
            'fcm_token'=>$request['fcm_token']??null,
        ]);

        if(!$user)
        {
            $message="something went wrong,try again later";
            $code=500;
            return ["user"=>$user,"message"=>$message,"code"=>$code];
        }

        // for email verification
        //this function send email the $request['email']
        event(new Registered($user));

        Profile::query()->create([
            "user_id"=>$user->id,
            'first_name'=>$request['first_name']??null,
            'last_name'=>$request['last_name']??null,
            'image_url'=>null,
            'gender'=>null,
            'phone_number'=>$request['phone_number'],
            'longitude'=>$request['longitude']??null,
            'latitude'=>$request['latitude']??null,
            'address'=>$request['address']??null,
        ]);

        $message='user registered successfully';
        $code=201;

        //jwt auth
        $token=auth('api')->login($user);
        $user['token']=$token;
        $user['token_type']='bearer';
        return ['user'=>$user,'message'=>$message,'code'=>$code];

    }
    public function login($request):array
    {
        $credentials = ['email'=>$request['email'],'password'=>$request['password']];

        $token = Auth('api')->attempt($credentials);

        if (!$token) {
            $user=null;
            $message = 'your email or password is wrong';
            $code=401;
        }


        else
        {
            $user = Auth('api')->user();
            $user['token']=  $token;
            $user['token_type']=  'Bearer';
            $message = 'User logged in successfully';
            $code=200;
            event(new Registered($user));
        }


        return ['user'=>$user,'message'=>$message,'code'=>$code];

    }
    public function logout():array
    {
        $user=Auth('api')->user();
        if(!is_null($user))
        {
            auth('api')->logout();
            $message='user logged out successfully';
            $code=200;
        }
        else
        {
            $message='invalid token';
            $code=404;
        }
        return ['user'=>$user,'message'=>$message,'code'=>$code];
    }
    public function refresh(Request $request):array
    {
        try {
            // اجلب التوكن من الهيدر
            $token = $request->bearerToken();


            if (!$token) {
                $user=null;
                $message = 'Token not provided';
                $code=401;
                return ['user'=>$user,'message'=>$message,'code'=>$code];
            }

            // استخدم الجارد jwt مباشرة
            $newToken = auth('api')->setToken($token)->refresh();
            $user=auth('api')->user();
            $user['token']=  $newToken;
            $user['token_type']=  'Bearer';
            $message='User Token refreshed successfully';
            $code=200;


            // مدة صلاحية التوكن (بالدقائق * 60 = ثواني)
            //  $ttl = auth('api')->factory()->getTTL();
            // there is a problem with this code

            return [
                'user'=>$user,'message'=>$message,'code'=>$code
                // 'expires_in' => $ttl * 60,
            ];
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
            $user=null;
            $message = 'Token invalid or expired';
            $code=401;
            return ['user'=>$user,'message'=>$message,'code'=>$code];
        }

    }
    public function forgetPassword(Request $request):array
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
    public function checkCode(Request $request):array
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
    public function resetPassword(Request $request):array
    {
        $input=$request->validate([
            'code'=>'required|string|exists:reset_code_passwords,code',
            'password'=>'required|string|confirmed',
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
        ResetCodePassword::query()->where('code','=',$input['code'])->delete();

        $credentials = ['email'=>$user['email'],'password'=>$request['password']];

        $token = Auth('api')->attempt($credentials);

        if (!$token) {
            $user=null;
            $message = 'your email or password is wrong';
            $code=401;
        }

        $user = Auth('api')->user();
        $user['token']=  $token;
        $user['token_type']=  'Bearer';

        $input=$user;


        $message='password reset successfully';
        $code=200;
        return ['info'=>$input,'message'=>$message,'code'=>$code];


    }


}
