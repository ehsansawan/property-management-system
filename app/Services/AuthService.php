<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            $message = 'Unauthorized';
            $code=401;
        }

        else
        {
            $user = Auth('api')->user();
            $user['token']=  $token;
            $user['token_type']=  'Bearer';
            $message = 'User logged in successfully';
            $code=200;
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


}
