<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\CreateProfileRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Responses\Response;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ProfileController extends Controller
{
    //
    protected ProfileService $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }
    public function get_my_profile():JsonResponse
    {
        $data=[];

        try {

            $data=$this->profileService->get_my_profile();
            return Response::Success($data['profile'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }
    public function show($id):JsonResponse
    {
        $data=[];

        try {

            $data=$this->profileService->show($id);
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
    public function update(UpdateProfileRequest $request):JsonResponse
    {
        $data=[];

        try {
            $data=$this->profileService->update($request->validated());
            return Response::Success($data['profile'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete(Request $request):JsonResponse
    {
        $data=[];

        try {
            $data=$this->profileService->delete($request);
            return Response::Success($data['profile'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }


}
