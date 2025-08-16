<?php

namespace App\Services;

use App\Models\Report;

class ReportService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function create($request)
    {
        $report=Report::query()->create([
           'user_id'=>auth('api')->id(),
            'ad_id'=>$request['ad_id'],
            'reason'=>$request['reason']??null,
        ]);

        $message='your report sent successfully';
        $code=200;
        return ['report'=>$report,'message'=>$message,'code'=>$code];
    }
    public function index()
    {
        //check if the user role is admin
        $reports=Report::query()->get();
        $message='your report sent successfully';
        $code=200;

        return ['reports'=>$reports,'message'=>$message,'code'=>$code];
    }
    public function show($id)
    {
        $report=Report::query()->find($id);
        if(!$report)
        {
            $message='your report not found';
            $code=404;
            return ['report'=>$report,'message'=>$message,'code'=>$code];
        }
        $message='your report sent successfully';
        $code=200;
        return ['report'=>$report,'message'=>$message,'code'=>$code];

    }
    public function showAdReports($ad_id)
    {
        $reports=Report::query()->where('ad_id',$ad_id)->get();
        $message='your reports on this ad sent successfully';
        $code=200;
        return ['reports'=>$reports,'message'=>$message,'code'=>$code];
    }
    public function delete($id)
    {
        $report=Report::query()->find($id);
        if(!$report)
        {
            $message='your report not found';
            $code=404;
            return ['report'=>$report,'message'=>$message,'code'=>$code];
        }
        $report->delete();
        $message='this report ignored successfully';
        $code=200;
        return ['report'=>$report,'message'=>$message,'code'=>$code];
    }


}
