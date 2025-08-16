<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Throwable;

class ReportController extends Controller
{
    //
    protected ReportService $reportService;
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }
    public function index()
    {
        $data=[];

        try {
            $data=$this->reportService->index();
            return Response::Success($data['report'],$data['message'],$data['code']);
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
            $data=$this->reportService->create($request);
            return Response::Success($data['report'],$data['message'],$data['code']);
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
            $data=$this->reportService->show($id);
            return Response::Success($data['report'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function showAdReports($ad_id)
    {
        $data=[];

        try {
            $data=$this->reportService->showAdReports($ad_id);
            return Response::Success($data['reports'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function igonre($id)
    {
        $data=[];

        try {
            $data=$this->reportService->delete($id);
            return Response::Success($data['report'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
}
