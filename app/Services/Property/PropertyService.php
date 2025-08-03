<?php

namespace App\Services\Property;

use App\Http\Responses\Response;
use App\Models\Image;
use App\Models\Property;
use App\Models\User;
use App\Services\UserService;
use App\Traits\PictureTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Nette\Schema\ValidationException;

class PropertyService
{
    use PictureTrait;
    protected ApartmentService $apartmentService;
    protected LandService $landService;
    protected OfficeService $officeService;
    protected ShopService $shopService;
    public function __construct(ApartmentService $apartmentService, LandService $landService,
                                OfficeService $officeService, ShopService $shopService
    )
    {
         $this->apartmentService = $apartmentService;
         $this->landService = $landService;
         $this->officeService = $officeService;
         $this->shopService = $shopService;
    }

    public function getProperty($id)
    {
        $property=Property::query()->with('propertyable','images')->find($id);
        if(!$property)
        {
            $message="Property not found";
            $code=404;
            return ['property'=>null,'message'=>$message,'code'=>$code];
        }
        $property['type']=class_basename($property->propertyable_type);
        return ['property'=>$property,'message'=>'property retrieved successfully','code'=>200];

    }
    public function getUserProperties($request)
    {
        $user_id=$request['user_id']??null;

        if(!$user_id)
            $user_id=auth('api')->id();

        $user=User::query()->find($user_id);
        if(!$user)
        {
            $message="User not found";
            $code=404;
            return ['properties'=>null,'message'=>$message,'code'=>$code];
        }
        $properties=$user->properties()->with('propertyable','images')->get();

        $properties= $properties->map(function ($property) {
            $prop = $property->toArray();
            $prop['type'] = class_basename($property->propertyable_type);
            return $prop;
        });
        // for returning a good formatting for the front_end

        return['properties'=>$properties,'message'=>'properties retrieved successfully','code'=>200];
    }
    public function create($request)
    {
        $data=collect($request);
        DB::beginTransaction();
        try{
            switch (strtolower($data->get('type')))
            {
                case 'apartment':
                   $apartment= $this->apartmentService->create($data);
                    $propertyable=$apartment['apartment'];
                    break;
                case 'land':
                    $land= $this->landService->create($data);
                    $propertyable=$land['land'];
                    break;
                case 'office':
                    $office= $this->officeService->create($data);
                    $propertyable=$office['office'];
                    break;
               case 'shop':
                   $shop= $this->shopService->create($data);
                   $propertyable=$shop['shop'];
                   break;
           }

           $data=collect($request['property']);

            $user_id=$data->get('user_id');
            if(!$user_id)
                $user_id=auth('api')->id();


           $property=$propertyable->property()->create(
               [
                   'user_id'=>$user_id,
                   //'location_id'=>$data->get('location_id'),
                   'area'=>$data->get('area'),
                   'price'=>$data->get('price'),
                   'name'=>$data->get('name'),
                   //'title'=>$data->get('title'),
                    'description'=>$data->get('description'),
                   'address'=>$data->get('address'),
                   'longitude'=>$data->get('longitude'),
                   'latitude'=>$data->get('latitude'),
               ]
            );
            $property=$property->refresh();
           $property['type']=$request['type'];
           $property['propertyable']=$propertyable;

           $images=$data->get('image',[]);

               foreach ($images as $image)
               {
                   $file_url=$this->StorePicture($image,'uploads/properties');
                   Image::query()->create([
                       'property_id'=>$property->id,
                       'image_url'=>$file_url,
                   ]);
               }

          $property['images']=$property->images;

            DB::commit();
          return['property'=>$property,'message'=>'property created successfully','code'=>201];
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            $message=$e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function update($request,$id)
    {
        $data=collect($request);
        $propertyable_id=Property::query()->where('id',$id)->value('propertyable_id');
        $propertyable_type=Property::query()->where('id',$id)->value('propertyable_type');

        if(!$propertyable_id)
        {
            $message="Property not found";
            $code=404;
            return ['property'=>null,'message'=>$message,'code'=>$code];
        }
        if($data->get('type') != strtolower(class_basename($propertyable_type)))
        {
            $message="Property type is not compatible with the type u send";
            $code=404;
            return ['property'=>null,'message'=>$message,'code'=>$code];
        }

        DB::beginTransaction();
        try{
            switch (strtolower($data->get('type')))
            {
                case 'apartment':
                    $apartment= $this->apartmentService->update($data,$propertyable_id);
                    $propertyable=$apartment['apartment'];
                    break;
                case 'land':
                    $land= $this->landService->update($data,$propertyable_id);
                    $propertyable=$land['land'];
                    break;
                case 'office':
                    $office= $this->officeService->update($data,$propertyable_id);
                    $propertyable=$office['office'];
                    break;
                case 'shop':
                    $shop= $this->shopService->update($data,$propertyable_id);
                    $propertyable=$shop['shop'];
                    break;
            }


            $property=Property::query()->find($id);

            $fields = ['area','name','description','price','address','longitude','latitude'];

            foreach ($fields as $field) {
                if (filled($data->get('property')[$field])) {

                    $property->{$field} = $data->get('property')[$field];
                }
            }

            $images_to_delete=$data->get('property')['image_to_delete']??[];


            foreach ($images_to_delete as $image) {
                if($image)
                {
                    $image=Image::query()->find($image);
                    $this->DestroyPicture($image);
                    $image->delete();
                }
            }

            $images=$data->get('property')['image']??[];

                foreach ($images as $image)
                {
                    if($image)
                    {
                        $file_url=$this->StorePicture($image,'uploads/properties');
                        Image::query()->create([
                            'property_id'=>$property->id,
                            'image_url'=>$file_url,
                        ]);
                    }
                }


            $property->save();
            $property->refresh();
            $property['images']=$property->images;
            $property['type']=$request['type'];
            $property['propertyable']=$propertyable;
            $message="Property updated successfully";
            $code=200;

            DB::commit();
            return['property'=>$property,'message'=>$message,'code'=>$code];
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            $message=$e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $property = Property::find($id);
            if(!$property)
            {
                $message="property not found";
                $code=404;
                return ['property'=>null,'message'=>$message,'code'=>$code];
            }

            $propertyable = $property->propertyable;

            $propertyable->delete();

            $file_urls=$property->images->pluck('image_url')->toArray();

            foreach ($file_urls as $file_url)
            {
                $this->DestroyPicture($file_url);
            }

            $property->delete();


            DB::commit();

            return [
                'property' => $property,
                'message' => 'Property deleted successfully',
                'code' => 200
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::Error(null, $e->getMessage());
        }
    }

//    public function delete($request,$id)
//    {
//
//        $propertyable_id=Property::query()->where('id',$id)->value('property_id');
//        //value = pluck()->first();
//        DB::beginTransaction();
//        try{
//            switch ($request->get('type'))
//            {
//                case 'Apartment':
//                    $apartment= $this->apartmentService->delete($propertyable_id);
//                    break;
//                case 'Land':
//                    $land= $this->landService->delete($propertyable_id);
//                    break;
//                case 'Office':
//                    $office= $this->officeService->delete($propertyable_id);;
//                    break;
//                case 'Shop':
//                    $shop= $this->shopService->delete($propertyable_id);;
//                    break;
//            }
//
//            $property=Property::query()->find($id);
//            $property->delete();
//
//            DB::commit();
//            $message="property deleted successfully";
//            $code=200;
//            return['property'=>$property,'message'=>$message,'code'=>$code];
//        }
//        catch (\Exception $e)
//        {
//            DB::rollBack();
//            $message=$e->getMessage();
//            return Response::Error(null,$message);
//        }
//    }
  public function getAttributes($request)
  {

      $valid=Validator::make($request->all(),['type'=>'required|string|in:Apartment,Land,Office,Shop']);

      if($valid->fails())
      {
          return ['attributes'=>null,'message'=>$valid->errors()->first(),'code'=>422];
      }

      switch ($request->get('type'))
            {
                case 'Apartment':
                   $data=$this->apartmentService->getAttributes();
                    break;
                case 'Land':
                   $data=$this->landService->getAttributes();
                    break;
                case 'Office':
                    $data=$this->officeService->getAttributes();
                    break;
                case 'Shop':
                    $data=$this->shopService->getAttributes();
                    break;
            }

      $data['property']=[
          'user_id'     => 'integer|exists:users,id',
        //  'location_id' => 'required|integer|exists:locations,id',
          'area'        => 'numeric',
          'name'        => 'string',
          'description' => 'string',
          'property.image'       => 'sometimes|array',
          'property.image.*'     => ['file'=>'mimes:jpeg,jpg,png,webp', 'max:4096'],
          'property.image_to_delete'=>'sometimes|array',
          'property.image_to_delete.*'=>'integer|exists:images,id',
          'property.latitude'     => 'nullable|numeric|between:-90,90',
          'property.longitude'    => 'nullable|numeric|between:-180,180',
          'property.address'      => 'string|nullable',
      ];
      $data['type']=$request->get('type');
      $message='data retired successfully';
      $code=200;
      return ['attributes'=>$data,'message'=>$message,'code'=>$code];

  }

}
