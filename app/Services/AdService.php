<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Apartment;
use App\Models\Land;
use App\Models\User;
use Carbon\Carbon;


class AdService
{
    /**
     * Create a new class instance.
     */
    protected array $propertyTypeMap = [
        'apartment' => \App\Models\Apartment::class,
        'land' => \App\Models\Land::class,
        'shop' => \App\Models\Shop::class,
        'office' => \App\Models\Office::class,
    ];
    public function __construct()
    {
        //
    }

    public function DamascusTime($ad)
    {
        $ad->start_date=$ad->start_date->timezone('Asia/Baghdad')->subHour(10);
        $ad->end_date=$ad->end_date->timezone('Asia/Baghdad')->subHour(10);
        return $ad;
    }
    public function getUserAds( $request) : array
    {
        $id=$request->id;

        //for admin
        if(!$request->id)
            $id=auth('api')->id();


        $user=User::query()->with('ads.property')->find($id);

        $ads=$user->ads;
        foreach($ads as $ad)
            $ad=$this->DamascusTime($ad);

        $message='user ads list';
        $code=200;
        return ['ads'=>$ads,'message'=>$message,'code'=>$code];

    }

    public function show($id) : array
    {
        $ad=Ad::query()->with(['property.images'])->find($id);

        if(!$ad)
        {
            $message='ad not found';
            $code=404;
            return ['ad'=>$ad,'message'=>$message,'code'=>$code];
        }

        if($ad->property->user->id!==auth('api')->id())
        $ad->increment('views');

        $ad=$this->DamascusTime($ad);
        $message='add retrieved successfully';
        $code=200;
        return ['ad'=>$ad,'message'=>$message,'code'=>$code];

    }

    public function create($request) :array
    {
       $start_date=Carbon::now();
       $end_date=now()->addDays(3);

       $ad=Ad::query()->create([
           'property_id'=>$request['property_id'],
          'start_date'=>$start_date,
          'end_date'=>$end_date,
       ]);

       $ad=$this->DamascusTime($ad);
       $message='ad created successfully';
       $code=200;
       return ['ad'=>$ad,'message'=>$message,'code'=>$code];

    }
    public function activate($id ):array
    {
        $ad=Ad::query()->find($id);

        if(!$ad)
        {
            $message='the ad does not published yet';
            $code=404;
            return ['ad'=>$ad,'message'=>$message,'code'=>$code];
        }
        $ad->start_date=Carbon::now();
        $ad->end_date=now()->addDays(3);
        $ad->is_active=true;
        $ad->save();

//        $ad->start_date=$ad->start_date->timezone('Asia/Baghdad')->subHour(10);
//        $ad->end_date=$ad->end_date->timezone('Asia/Baghdad')->subHour(10);

        $ad=$this->DamascusTime($ad);

        $message='ad activated successfully';
        $code=200;

        return ['ad'=>$ad,'message'=>$message,'code'=>$code];
    }
    public function getAdsByPropertyType($request): array
    {
        if (!array_key_exists(strtolower($request['type']), $this->propertyTypeMap)) {
            return [
                'ads' => [],
                'message' => 'Invalid property type: ' . $request['type'],
                'code' => 400
            ];
        }

        $class = $this->propertyTypeMap[strtolower($request['type'])];
        $ads = Ad::query()
            ->where('is_active', true)
            ->whereHas('property', fn($q) => $q->where('propertyable_type', $class))
            ->with(['property.propertyable','property.images'])
            ->get();

        return [
            'ads' => $ads,
            'message' => 'Get ' . ucfirst(strtolower($request['type'])) . ' ads',
            'code' => 200
        ];
    }

}
