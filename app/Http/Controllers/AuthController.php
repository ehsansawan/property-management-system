<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\Response;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{

 private AuthService $authService;

public function __construct(AuthService $authService)
{
$this->authService=$authService;
}

public function register(RegisterRequest $request): JsonResponse
{
    $data=[];
    try{
        $data=$this->authService->register($request->validated());
        return  Response::Success($data['user'],$data['message'],$data['code']);
    }
    catch (Throwable $th){
        $message=$th->getMessage();
        return Response::Error($data,$message);
    }
}
public function login(LoginRequest $request): JsonResponse
{
    $data=[];
    try{
        $data=$this->authService->login($request->validated());
        return  Response::Success($data['user'],$data['message'],$data['code']);
    }
    catch (Throwable $th){
        $message=$th->getMessage();
        return Response::Error($data,$message);
    }
}

    public function logout():JsonResponse
    {
        $data=[];

        try {
            $data=$this->authService->logout();
            return Response::Success($data['user'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function refresh(Request $request):JsonResponse
    {
        $data=[];
        try {
            $data=$this->authService->refresh($request);
            return Response::Success($data['user'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

}
