<?php

namespace App\Services\Location;



use App\Models\Governorate;
use Illuminate\Support\Facades\Validator;

class GovernorateService
{

    public function __construct()
    {
        //
    }
    public function index()
    {
        $governorates=Governorate::all();
        $message="Governorate List";
        $code=200;
        return['governorates'=>$governorates,'message'=>$message,'code'=>$code];
    }
    public function create($request)
    {
        $valid=Validator::make($request->all(),[
            'name'=>'required|string|unique:governorates,name',
        ]);
        if($valid->fails())
        {
            return ['governorate'=>null,'message'=>$valid->errors(),'code'=>422];
        }
        $governorate=Governorate::query()->create([
            'name'=>$request->name,
        ]);
        $message="Governorate created successfully";
        $code=201;
        return ['governorate'=>$governorate,'message'=>$message,'code'=>$code];
    }
    public function update($request,$id)
    {
        $governorate=Governorate::query()->find($id);
        if(!$governorate)
        {
            return ['governorate'=>null,'message'=>'Governor not found','code'=>404];
        }
        $valid=Validator::make($request->all(),['name'=>'required|string|unique:governorates,name']);
        if($valid->fails())
        {
            return ['governorate'=>null,'message'=>$valid->errors(),'code'=>422];
        }
        if($request->name!=$governorate->name)
        $governorate->name=$request->name;
        $governorate->save();
        $message="Governorate updated successfully";
        $code=200;
        return ['governorate'=>$governorate,'message'=>$message,'code'=>$code];
    }
    public function delete($id)
    {
        $governorate=Governorate::query()->find($id);
        if(!$governorate)
            return ['governorate'=>null,'message'=>'Governor not found','code'=>404];

        $governorate->delete();
        $message="Governorate deleted successfully";
        $code=200;
        return ['governorate'=>$governorate,'message'=>$message,'code'=>$code];
    }
}
