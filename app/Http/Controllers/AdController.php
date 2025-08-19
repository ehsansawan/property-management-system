<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ads\ActivateSelectedAdsRequest;
use App\Http\Requests\Ads\CreateAdRequest;
use App\Http\Requests\Ads\SearchAdRequest;
use App\Http\Responses\Response;
use App\Services\AdService;
use Illuminate\Http\Request;
use Throwable;

class AdController extends Controller
{
    //
    protected AdService $adservice;
    public function __construct(AdService $adService)
    {
        $this->adservice = $adService;
    }

    public function getUserAds(Request $request)
    {
        $data=[];

        try {
            $data=$this->adservice->getUserAds($request);
            return Response::Success($data['ads'],$data['message'],$data['code']);
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
            $data=$this->adservice->show($id);
            return Response::Success($data['ad'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function activate($id)
    {
        $data=[];

        try {
            $data=$this->adservice->activate($id);
            return Response::Success($data['ad'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function create(CreateAdRequest $request)
    {
        $data=[];

        try {
            $data=$this->adservice->create($request->validated());
            return Response::Success($data['ad'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function getAdsByPropertyType(Request $request)
    {
        $data=[];

        try {
            $data=$this->adservice->getAdsByPropertyType($request);
            return Response::Success($data['ads'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function activateSelectedAds(ActivateSelectedAdsRequest $request)
    {
        $data=[];

        try {
            $data=$this->adservice->activateSelectedAds($request->validated());
            return Response::Success($data['ads'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function unactivate($id)
    {
        $data=[];

        try {
            $data=$this->adservice->unactivate($id);
            return Response::Success($data['ad'],$data['message'],$data['code']);
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
            $data=$this->adservice->delete($id);
            return Response::Success($data['ad'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function nearToYou(Request $request)
    {
        $data=[];

        try {
            $data=$this->adservice->nearToYou($request);
            return Response::Success($data['ads'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function search(SearchAdRequest $request)
    {
        $data=[];

        try {
            $data=$this->adservice->Search($request->validated());
            return Response::Success($data['ads'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function recommend(Request $request)
    {
        $data=[];

        try {
            $data=$this->adservice->recommend($request);
            return Response::Success($data['ads'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function similarTo($id)
    {
        $data=[];

        try {
            $data=$this->adservice->similarTo($id);
            return Response::Success($data['ads'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }



}
