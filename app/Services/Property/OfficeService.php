<?php

namespace App\Services\Property;

use App\Models\Office;
use App\Models\User;

class OfficeService
{
    public function __construct()
    {

    }
    public function getOfficeList($user_id)
    {
       $user=User::query()->find($user_id);
       $offices=$user->offices()->with('propertyable')->get();
        // look at the implementation of offices() at user model
        //so we use with ('propertyable') with Property
        $message='offices retrieved successfully';
        $code=200;
        return ['offices'=>$offices,'message'=>$message,'code'=>$code];
    }
    public function getOffice($id)
    {
        $office=Office::query()->with('property')->find($id);
        $message='office retrieved successfully';
        $code=200;
        return ['office'=>$office,'message'=>$message,'code'=>$code];
    }
    public function create($request)
    {
        $data=collect($request->get('data'));

        $office=Office::query()->create([
            'floor'=>$data->get('floor'),
            'rooms'=>$data->get('rooms'),
            'bathrooms'=>$data->get('bathrooms'),
            'meeting_rooms'=>$data->get('meeting_rooms'),
            'has_parking'=>$data->get('has_parking'),
            'furnished'=>$data->get('furnished'),
         //   'furnished_type'=>$data->get('furnished_type'),
        ]);
        $message="office added successfully";
        $code=201;
        return ['office'=>$office,'message'=>$message,'code'=>$code];
    }
    public function update($request,$id)
    {
        $office=Office::query()->find($id);
        $data=collect($request->get('data'));
        $fields = [ 'floor','rooms','bathrooms','meeting_rooms','has_parking','furnished',
          //  'furnished_type'
        ];

        foreach ($fields as $field) {
            if (filled($data->get($field))) {
                $office->{$field} = $data->get($field);
            }
        }

        $office->save();
        $message='office updated successfully';
        $code=200;
        return ['office'=>$office,'message'=>$message,'code'=>$code];
    }
    public function delete($id)
    {
        $office=Office::query()->find($id);
        $office->delete();
        $message='office deleted successfully';
        $code=200;
        return ['office'=>$office,'message'=>$message,'code'=>$code];
    }
    public function getAttributes()
    {
        $attributes=[
            'floor'=>'required|integer',
            'rooms'=>'required|integer',
            'bathrooms'=>'required|integer',
            'meeting_rooms'=>'integer',
            'has_parking'=>'boolean',
            'furnished'=>'required|boolean',
      //      'furnished_type'=>'nullable|string|in:economic,standard,delux,super_delux,luxury',
        ];

        return ['attributes'=>$attributes];
    }
    public function search($query,$request)
    {
        $query=$query->join('offices','properties.propertyable_id','=','offices.id')
            ->where('properties.propertyable_type',\App\Models\Office::class);

        if(isset($request['floor']))
        {
            $query->where('offices.floor','>=',$request['floor']);
        }
        if(isset($request['rooms']))
        {
            $query->where('offices.rooms','>=',$request['rooms']);
        }
        if(isset($request['bathrooms']))
        {
            $query->where('offices.bathrooms','>=',$request['bathrooms']);
        }
        if(isset($request['meeting_rooms']))
        {
            $query->where('offices.meeting_rooms','>=',$request['meeting_rooms']);
        }
        if(!empty($request['has_parking']))
        {
            $query->where('offices.has_parking','=',$request['has_parking']);
        }
        if(!empty($request['furnished']))
        {
            $query->where('offices.furnished','=',$request['furnished']);
        }

//
//        'data.floor'=>'integer',
//            'data.rooms'=>'integer',
//            'data.bathrooms'=>'integer',
//            'data.meeting_rooms'=>'integer',
//            'data.has_parking'=>'boolean',
//            'data.furnished'=>'boolean',
        return $query;

    }
}
