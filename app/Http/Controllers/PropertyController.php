<?php

namespace App\Http\Controllers;

use App\Http\Requests\Property\CreatePropertyRequest;
use App\Http\Requests\Property\UpdatePropertyRequest;
use App\Http\Responses\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Property\PropertyService;
use Throwable;

class PropertyController extends Controller
{
    //
    protected PropertyService $propertyService;
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }
    public function getUserProperties($user_id):JsonResponse
    {
        $data=[];

        try {
            $data=$this->propertyService->getUserProperties($user_id);
            return Response::Success($data['properties'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function create(CreatePropertyRequest $request):JsonResponse
    {
        $data=[];

        try {
            $data=$this->propertyService->create($request->validated());
            return Response::Success($data['property'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function update(UpdatePropertyRequest $request,$id):JsonResponse
    {
        $data=[];

        try {
            $data=$this->propertyService->update($request->validated(),$id);
            return Response::Success($data['property'],$data['message'],$data['code']);
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
            $data=$this->propertyService->delete($id);
            return Response::Success($data['property'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

}
