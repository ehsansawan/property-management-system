<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profle\CreateProfileRequest;
use App\Http\Requests\Profle\UpdateProfileRequest;
use App\Http\Responses\Response;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProfileController extends Controller
{
    //
    protected ProfileService $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show($user_id):JsonResponse
    {
        $data=[];

        try {
            $data=$this->profileService->show($user_id);
            return Response::Success($data['profile'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }
    public function create(CreateProfileRequest $request):JsonResponse
    {
        $data=[];

        try {
            $data=$this->profileService->create($request->validated());
            return Response::Success($data['profile'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function update(UpdateProfileRequest $request, $user_id):JsonResponse
    {
        $data=[];

        try {
            $data=$this->profileService->update($request->validated(),$user_id);
            return Response::Success($data['profile'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete($user_id):JsonResponse
    {
        $data=[];

        try {
            $data=$this->profileService->delete($user_id);
            return Response::Success($data['profile'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }


}
