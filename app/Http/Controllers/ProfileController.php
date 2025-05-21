<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
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

    public function create(ProfileRequest $request):JsonResponse
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
    public function update(ProfileRequest $request,$id):JsonResponse
    {
        $data=[];

        try {
            $data=$this->profileService->update($request->validated(),$id);
            return Response::Success($data['profile'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete($id):JsonResponse
    {
        $data=[];

        try {
            $data=$this->profileService->delete($id);
            return Response::Success($data['profile'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }


}
