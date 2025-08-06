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
    public function format($ads)
    {
        if($ads instanceof \Illuminate\Database\Eloquent\Collection) {
            $ads=$ads->map(function($ad)  {
                $ad=$this->DamascusTime($ad);
                $ad['property']['type']=class_basename($ad['property']['propertyable_type']);
                return $ad;
            });
        }
        else
        {
            $ads=$this->DamascusTime($ads);
            $ads['property']['type']=class_basename($ads['property']['propertyable_type']);
        }
        return $ads;
    }
    public function getUserAds( $request) : array
    {
        //for admin
        $id=$request->id;


        if(!$request->id)
            $id=auth('api')->id();


        $user=User::query()->with(['ads.property.images','ads.property.propertyable'])->find($id);
        if(!$user)
        {
            return ['ads'=>null,'message'=>'user not found','code'=>404];
        }

        $ads=$user->ads;
        $ads=$this->format($ads);

        $message='user ads list';
        $code=200;
        return ['ads'=>$ads,'message'=>$message,'code'=>$code];

    }
    public function show($id) : array
    {
        $ad=Ad::query()->with(['property.propertyable','property.images'])->find($id);

        if(!$ad)
        {
            $message='ad not found';
            $code=404;
            return ['ad'=>$ad,'message'=>$message,'code'=>$code];
        }

        if($ad->property->user_id!==auth('api')->id())
        $ad->increment('views');

        $ad=$this->format($ad);
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

       $ad->property()->update(['is_ad'=>true]);
       $ad=Ad::query()->with(['property.images','property.propertyable'])->find($ad->id);

       $ad=$this->format($ad);
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

      $ads=$this->format($ads);


        return [
            'ads' => $ads,
            'message' => 'Get ' . ucfirst(strtolower($request['type'])) . ' ads',
            'code' => 200
        ];
    }
    public function search(array $filters):array
    {
        $query = Ad::with(['property.images','property.propertyable']); // نجيب العقار مع الصور

        // فلترة حسب خصائص العقار
        $query->whereHas('property', function ($q) use ($filters) {


            if (!empty($filters['type'])) {
                $q->where('type', $filters['type']);
            }

            if (!empty($filters['min_price'])) {
                $q->where('price', '>=', $filters['min_price']);
            }

            if (!empty($filters['max_price'])) {
                $q->where('price', '<=', $filters['max_price']);
            }

            if (!empty($filters['min_space'])) {
                $q->where('space', '>=', $filters['min_space']);
            }

            if (!empty($filters['max_space'])) {
                $q->where('space', '<=', $filters['max_space']);
            }

            // أضف أي خصائص إضافية للعقار حسب الحاجة
        });

        return $query->get(); // لاحقًا منرجع لـ paginate
    }
    public function activateSelectedAds($request):array
    {

        $user=$request['user_id']??null;
        if(!$user)
            $user=auth('api')->user();
        if(!$user)
        {
            return ['ads'=>null,'message'=>'enter user id or token','code'=>404];
        }

     $all=$request['all']??null;
        if($all)
        {

//         $adsCount=$user->ads()->count();
//         if($adsCount>3)
//         {
//             return ['ads'=>[],'message'=>'you have to upgrade your acount to have +3 ads activated'];
//         }

         //updating the ads
         $user->ads()->update(['is_active'=>true,
         'start_date'=>Carbon::now(),'end_date'=>Carbon::now()->addDays(3)]);

         $ads=$user->ads;

         return ['ads'=>$ads,'message'=>'ads activated successfully','code'=>200];

        }

        $ids_to_activate=$request['ads']??[];

//        $currentActivateCount=$user->ads()->where('is_active',true)->count();
//        $ads_to_activate=$user->ads()->whereIn('id',$ids_to_activate)->get();
//
//        $inactivateAdsToActivate=$ads_to_activate->filter(function ($ad)
//        {
//            return $ad->is_active == false;
//        });
//
//        if($inactivateAdsToActivate->count()+$currentActivateCount>3)
//        {
//            return ['ads'=>null,'message'=>'u have to upgrade your acount to have +3 ads activated','code'=>404];
//        }

        // here u have to check the number of ads
        //first u have ot check the number of activated ads
        //then check the $ids if its similar and more than 3 the total of the selected ads and the activated you have to throw an error



        foreach($ids_to_activate as $id)
        {

            Ad::query()->where('id',$id)
                ->update(['is_active'=>true,'start_date'=>Carbon::now(),'end_date'=>Carbon::now()->addDays(3)]);

            $ad=Ad::query()->find($id);
            $ad=$this->DamascusTime($ad);
            $ads[]=$ad;
        }

        return ['ads'=>$ads,'message'=>'ads activated successfully','code'=>200];
    }
    public function unactivate($id) :array
    {

        $ad=Ad::query()->find($id);
        if(!$ad)
        {
            $message='the ad does not published yet';
            $code=404;
            return ['ad'=>$ad,'message'=>$message,'code'=>$code];
        }
        $ad->is_active=false;
        $ad->save();

        $ad=$this->DamascusTime($ad);
        $message='ad unactivated successfully';
        $code=200;
        return ['ad'=>$ad,'message'=>$message,'code'=>$code];
    }
    public function delete($id):array
    {
        $ad=Ad::query()->find($id);

        if(!$ad)
        {
            $message='there is no add to delete';
            $code=404;
            return ['ad'=>$ad,'message'=>$message,'code'=>$code];
        }
        $ad->property->is_ad=false;
        $ad->property->save(); // ✅ This line is required
        $ad->delete();
        $message='deleted successfully';
        $code=200;
        return ['ad'=>$ad,'message'=>$message,'code'=>$code];
    }
    public function nearToYou($request): array
    {
        $user = auth('api')->user();

        $userLat = $user->profile->latitude;
        $userLng = $user->profile->longitude;

        // تأكد إنو عنده إحداثيات
        if (!$userLat || !$userLng) {
            return [
                'ads' => [],
                'message' => 'User location not set',
                'code' => 422,
            ];
        }

        // المسافة باستخدام Haversine

        $user = auth()->user();
        $userLat = $user->profile->latitude;
        $userLng = $user->profile->longitude;

        $ads = Ad::query()
            ->where('is_active', true)
            ->whereHas('property', function ($query) {
                $query->whereNotNull('latitude')
                    ->whereNotNull('longitude');
            })
            ->join('properties', 'ads.property_id', '=', 'properties.id')
            ->selectRaw('ads.*, properties.latitude, properties.longitude,
        6371 * acos(
            cos(radians(?)) * cos(radians(properties.latitude)) *
            cos(radians(properties.longitude) - radians(?)) +
            sin(radians(?)) * sin(radians(properties.latitude))
        ) as distance', [$userLat, $userLng, $userLat])
            ->with([
                'property.images',
                'property.propertyable'
            ])
            ->orderBy('distance')
            ->paginate($request['number']??10);

        $ads->getCollection()->transform(fn($ad) => $this->format($ad));
    //    $ads=$this->format($ads);

        //we need propertyable + type
        return [
            'ads' => $ads,
            'message' => 'Ads near you',
            'code' => 200,
        ];
    }

}
