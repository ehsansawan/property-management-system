<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function __construct()
    {
    }

    public function index() : array
    {
        $user = Auth::guard('api')->user();
        $data = $user->favorites;
        $message = "Favorites retrieved successfully";
        $code = 200;
        return [ 'data' => $data, 'message' => $message, 'code' => $code ];
    }

    public function add($property_id) : array 
    {
        $user = Auth::guard('api')->user();
        $pr = Property::find($property_id);

        if(!$pr)
        {
            $message = "Property not found";
            $code = 400;
            return [ 'data' => null, 'message' => $message, 'code' => $code ];
        }

        if($user->favorites->where('property_id', $pr->id)->first() != null)
        {
            $message = "Property already added to favorites";
            $code = 400;
            return [ 'data' => null, 'message' => $message, 'code' => $code ];
        }

        $data = Favorite::create([
            'property_id' => $property_id,
            'user_id' => $user->id,
        ]);

        $message = "Property added to favorites successfully";
        $code = 200;
        return [ 'data' => $data, 'message' => $message, 'code' => $code ];
    }

    public function remove($property_id) : array
    {
        $user = Auth::guard('api')->user();
        if(!$user->favorites->where('property_id', $property_id)->first())
        {
            $message = "Property not found in favorites";
            $code = 400;
            return [ 'data' => null, 'message' => $message, 'code' => $code ];
        }
        $data = $user->favorites->where('property_id', $property_id)->first();
        $data->delete();
        $message = "Property removed from favorites successfully";
        $code = 200;
        return [ 'data' => null, 'message' => $message, 'code' => $code ];
    }

    public function IsInFavorites($property_id) : array
    {
        $user = Auth::guard('api')->user();
        if($user->favorites->where('property_id', $property_id)->first() != null)
        {
            $message = "Property found in favorites";
            $code = 200;
            return [ 'data' => 'true', 'message' => $message, 'code' => $code ];
        }
        else 
        {
            $message = "Property not found in favorites";
            $code = 200;
            return [ 'data' => 'false', 'message' => $message, 'code' => $code ];
        }
    }
}
