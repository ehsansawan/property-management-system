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
        $data=collect($request->get('Shop'));

        $shop=Shop::query()->create(
            [
                'floor'=>$data->get('floor'),
                'type'=>$data->get('type'),
                'has_warehouse'=>$data->get('has_warehouse'),
            ]
        );
        $message='shop created successfully';
        $code=201;
        return ['shop'=>$shop,'message'=>$message,'code'=>$code];
    }
    public function update($request,$id)
    {
        $data=collect($request->get('Shop'));
        $shop=Shop::query()->find($id);

        $fields = [  'floor','type','has_warehouse'];

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
}
