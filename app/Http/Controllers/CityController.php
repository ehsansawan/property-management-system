<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Services\Location\CityService;
use Illuminate\Http\Request;
use Throwable;

class CityController extends Controller
{
    //
    protected CityService $cityService;
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }
    public function show($id)
    {
        $data=[];

        try {
            $data=$this->cityService->show($id);
            return Response::Success($data['city'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function getCitiesByGovernorate($governorate_id)
    {

        $data=[];

        try {
            $data=$this->cityService->getCitiesByGovernorate($governorate_id);
            return Response::Success($data['cities'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function create(Request $request)
    {
        $data=[];

        try {
            $data=$this->cityService->create($request);
            return Response::Success($data['city'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function update(Request $request,$id)
    {
        $data=[];

        try {
            $data=$this->cityService->update($request,$id);
            return Response::Success($data['city'],$data['message'],$data['code']);
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
            $data=$this->cityService->delete($id);
            return Response::Success($data['city'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
}
