<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSuggestedLocationRequest;
use App\Http\Responses\Response;
use App\Services\Location\SuggestedLocationService;
use Illuminate\Http\Request;
use Throwable;

class SuggestedLocationController extends Controller
{
    //
    protected SuggestedLocationService $suggestedLocationService;
    public function __construct(SuggestedLocationService $suggestedLocationService)
    {
        $this->suggestedLocationService = $suggestedLocationService;
    }
    public function index()
    {
        $data=[];

        try {
            $data=$this->suggestedLocationService->index();
            return Response::Success($data['locations'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function userSuggestedLocations(Request $request)
    {
        $data=[];

        try {
            $data=$this->suggestedLocationService->userSuggestedLocations($request);
            return Response::Success($data['locations'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function suggestedLocationsByGovernorate(Request $request)
    {
        $data=[];

        try {
            $data=$this->suggestedLocationService->suggestedLocationsByGovernorate($request);
            return Response::Success($data['locations'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function show($id)
    {
        $data=[];

        try {
            $data=$this->suggestedLocationService->show($id);
            return Response::Success($data['location'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function create(CreateSuggestedLocationRequest $request)
    {
        $data=[];

        try {
            $data=$this->suggestedLocationService->create($request);
            return Response::Success($data['location'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function update(Request $request, $id)
    {
        $data=[];

        try {
            $data=$this->suggestedLocationService->update($request,$id);
            return Response::Success($data['location'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete($id)
    {
        $data=[];

        try {
            $data=$this->suggestedLocationService->delete($id);
            return Response::Success($data['location'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function approve($id)
    {
        $data=[];
        try {
            $data=$this->suggestedLocationService->approve($id);
            return Response::Success($data['location'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

}
