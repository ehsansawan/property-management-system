<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Models\Governorate;
use App\Services\Location\GovernorateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class GovernorateController extends Controller
{
    //
    protected GovernorateService $governorateService;
    public function __construct(GovernorateService $governorateService)
    {
        $this->governorateService = $governorateService;
    }

    public function index()
    {
        $data=[];

        try {
            $data=$this->governorateService->index();
            return Response::Success($data['governorates'],$data['message'],$data['code']);
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
            $data=$this->governorateService->create($request);
            return Response::Success($data['governorate'],$data['message'],$data['code']);
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
            $data=$this->governorateService->update($request,$id);
            return Response::Success($data['governorate'],$data['message'],$data['code']);
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
            $data=$this->governorateService->delete($id);
            return Response::Success($data['governorate'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
}
