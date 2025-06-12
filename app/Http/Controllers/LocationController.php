<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Services\Location\LocationService;
use Illuminate\Http\Request;
use Throwable;

class LocationController extends Controller
{
    //
    protected LocationService $locationService;
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }
    public function index()
    {
        $data=[];

        try {
            $data=$this->locationService->index();
            return Response::Success($data['locations'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function create(Request $request){
        $data=[];

        try {
            $data=$this->locationService->create($request);
            return Response::Success($data['location'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function update(Request $request,$id){
        $data=[];

        try {
            $data=$this->locationService->update($request,$id);
            return Response::Success($data['location'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete($id){
        $data=[];

        try {
            $data=$this->locationService->delete($id);
            return Response::Success($data['location'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
}
