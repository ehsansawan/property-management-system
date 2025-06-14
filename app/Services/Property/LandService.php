<?php

namespace App\Services\Property;

use App\Models\Land;
use App\Models\User;

class LandService
{
    public function __construct()
    {

    }
    public function getLandList($user_id)
    {
       $user=User::query()->find($user_id);

        $lands=$user->lands()->with('propertyable')->get();
        // look at the implementation of lands() at user model
        //so we use with ('propertyable') with Property
        $message="lands retrieved successfully";
        $code=200;
        return ['lands'=>$lands,'message'=>$message,'code'=>$code];
    }
    public function getLand($id)
    {
        $land=Land::query()->with('property')->find($id);

        $message="Land retrieved successfully";
        $code=200;
        return ['land'=>$land,'message'=>$message,'code'=>$code];

    }
    public function create($request)
    {
        $data=collect($request->get('data'));


        $land=Land::query()->create([
            'type'=>$data->get('type'),
            'is_inside_master_plan'=>$data->get('is_inside_master_plan'),
            'slope'=>$data->get('slope'),
            'is_serviced'=>$data->get('is_serviced'),
        ]);


        $message="land created successfully";
        $code=201;
        return ['land'=>$land,'message'=>$message,'code'=>$code];

    }
    public function update($request,$id)
    {
        $data=collect($request->get('data'));
        $land=Land::query()->find($id);


        $fields = ['type','is_serviced','slope','is_inside_master_plan'];

        foreach ($fields as $field) {
            if (filled($data->get($field))) {
                $land->{$field} = $data->get($field);
            }
        }
        $land->save();
        $message="Land updated successfully";
        $code=200;
        return ['land'=>$land,'message'=>$message,'code'=>$code];
    }
    public function delete($id)
    {
        $land=Land::query()->find($id);

        $land->delete();
        $message="Land deleted successfully";
        $code=200;
        return ['land'=>$land,'message'=>$message,'code'=>$code];
    }
    public function getAttributes()
    {
        $attributes=
            [
                'type'=>'required|string|in:industrial,agricultural,commercial,residential',
                'is_inside_master_plan'=>'boolean',
                'is_serviced'=>'boolean',
                'slope'=>'nullable|string|in:flat,sloped,mountainous'
            ];


        return ['attributes'=>$attributes];

    }


}
