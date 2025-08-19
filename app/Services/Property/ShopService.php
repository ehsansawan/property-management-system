<?php

namespace App\Services\Property;

use App\Models\Shop;
use App\Models\User;

class ShopService
{
    public function __construct()
    {

    }
    public function getShopsList($user_id)
    {
       $user=User::query()->find($user_id);
       $shops=$user->shops()->with('propertable')->get();

        $message='shops retrieved successfully';
        $code=200;
        return ['shops'=>$shops,'message'=>$message,'code'=>$code];
    }
    public function getShop($shop_id)
    {
        $shop=Shop::query()->with('property')->find($shop_id);
        $message='shop retrieved successfully';
        $code=200;
        return ['shop'=>$shop,'message'=>$message,'code'=>$code];
    }
    public function create($request)
    {
        $data=collect($request->get('data'));

        $shop=Shop::query()->create(
            [
                'floor'=>$data->get('floor'),
                'type'=>$data->get('type'),
                'has_warehouse'=>$data->get('has_warehouse'),
                'has_bathroom'=>$data->get('has_bathroom'),
                'has_ac'=>$data->get('has_ac'),
            ]
        );
        $message='shop created successfully';
        $code=201;
        return ['shop'=>$shop,'message'=>$message,'code'=>$code];
    }
    public function update($request,$id)
    {
        $data=collect($request->get('data'));
        $shop=Shop::query()->find($id);

        $fields = [  'floor','type','has_warehouse','has_bathroom','has_ac'];

        foreach ($fields as $field) {
            if (filled($data->get($field))) {
                $shop->{$field} = $data->get($field);
            }
        }


        $shop->save();
        $message='shop updated successfully';
        $code=200;
        return ['shop'=>$shop,'message'=>$message,'code'=>$code];
    }
    public function delete($id)
    {
        $shop=Shop::query()->find($id);
        $shop->delete();
        $message='shop deleted successfully';
        $code=200;
    }
    public function getAttributes()
    {
        $attributes=[
            'floor'=>'required|integer',
            'type'=>'required|string|in:retail,grocery,pharmacy,bookstore,restaurant,salon,other',
            'has_warehouse'=>'boolean',
            'has_bathroom'=>'boolean',
            'has_ac'=>'boolean',
        ];

        return ['attributes'=>$attributes];
    }
    public function search($query,$request)
    {

        $query=$query->join('shops','properties.propertyable_id','=','shops.id')
            ->where('properties.propertyable_type',\App\Models\Shop::class);


//        if(isset($request['floor']))
//        {
//            $query->where('shops.floor','>=',$request['floor']);
//        }

        if(!empty($request['ShopType']))
        {
            if(is_array($request['ShopType']))
            $query->whereIn('shops.type',$request['ShopType']);
            else
            $query->where('shops.type',$request['ShopType']);
        }
        if(!empty($request['has_warehouse']))
        {
            $query->where('shops.has_warehouse',$request['has_warehouse']);
        }
        if(!empty($request['has_bathroom']))
        {
            $query->where('shops.has_bathroom',$request['has_bathroom']);
        }
        if(!empty($request['has_ac']))
        {
            $query->where('shops.has_ac',$request['has_ac']);
        }

        return $query;

    }
    public function similarTo($ad,$query)
    {
        $request['ShopType']      = $ad['type'] ?? null;
        $request['has_warehouse'] = $ad['has_warehouse'] ?? 0;
        $request['has_bathroom']  = $ad['has_bathroom'] ?? 0;
        $request['has_ac']        = $ad['has_ac'] ?? 0;


        $query=$query->join('shops','properties.propertyable_id','=','shops.id')
            ->where('properties.propertyable_type',\App\Models\Shop::class)
            ->selectRaw("
            (0
             + CASE WHEN shops.type = ? THEN 5 ELSE 0 END
             + CASE WHEN shops.has_warehouse = ? THEN 1 ELSE 0 END
             + CASE WHEN shops.has_bathroom = ? THEN 1 ELSE 0 END
             + CASE WHEN shops.has_ac = ? THEN 1 ELSE 0 END
            ) as points
        ", [
                $request['ShopType'],
                $request['has_warehouse'],
                $request['has_bathroom'],
                $request['has_ac'],
            ])
            ->orderByDesc('points');


        return $query;
    }

}
