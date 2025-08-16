<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Support\Facades\Validator;

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
            'description'=>$request['description']??null,
        ]);

        $report=$report->with(['user','ad'])->find($report->id);
        $message='your report sent successfully';
        $code=200;
        return ['report'=>$report,'message'=>$message,'code'=>$code];
    }
    public function index($request)
    {
        $valid=Validator::make($request->all(),[
            'reason'=>'sometimes|array',
            'reason.*' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'sexual_content',
                    'harassment',
                    'spam',
                    'hate_speech',
                    'violence',
                    'scam',
                    'fake_information',
                    'other',
                ]),
            ],
            'number'=>'integer|between:1,100',
        ]);

        if($valid->fails()){
            return ['reports'=>null,'message'=>$valid->errors(),'code'=>422];
        }

        if(count($request['reason']??[])>0)
        {
            $reports=Report::query()->whereIn('reason',$request['reason']);
            $reports=$reports->with(['user','ad'])->paginate($request['num']??10);
        }
        else
        {
            //check if the user role is admin
            $reports=Report::query()->with(['user','ad'])->paginate($request['num']??10);
        }

        $message='reports sent successfully';
        $code=200;

        return ['reports'=>$reports,'message'=>$message,'code'=>$code];
    }
    public function show($id)
    {
        $report=Report::query()->with(['user','ad'])->find($id);
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
    // u can to categories this to show the reasons type u want
    public function showAdReports($request)
    {
        $valid=Validator::make($request->all(),[
            'ad_id'=>'required|integer|exists:ads,id',
            'reason'=>'sometimes|array',
            'reason.*' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'sexual_content',
                    'harassment',
                    'spam',
                    'hate_speech',
                    'violence',
                    'scam',
                    'fake_information',
                    'other',
                ]),
            ],
            'num'=>'integer|between:1,100',
        ]);


        if($valid->fails()){
            return ['reports'=>null,'message'=>$valid->errors(),'code'=>422];
        }

        $reports=Report::query()->with(['user','ad'])
            ->where('ad_id',$request['ad_id']);

        if(count($request['reason']??[])>0)
        $reports=$reports->whereIn('reason',$request['reason']);

        $reports=$reports->paginate($request['num']??10);

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
