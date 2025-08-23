<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Favorite;
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

    public function add($ad_id) : array
    {
        $user = Auth::guard('api')->user();
        $pr = Ad::find($ad_id);

        if(!$pr)
        {
            $message = "Ad not found";
            $code = 400;
            return [ 'data' => null, 'message' => $message, 'code' => $code ];
        }

        if($user->favorites->where('ad_id', $pr->id)->first() != null)
        {
            $message = "Ad already added to favorites";
            $code = 400;
            return [ 'data' => null, 'message' => $message, 'code' => $code ];
        }

        $data = Favorite::create([
            'ad_id' => $ad_id,
            'user_id' => $user->id,
        ]);

        $message = "Ad added to favorites successfully";
        $code = 200;
        return [ 'data' => $data, 'message' => $message, 'code' => $code ];
    }

    public function remove($ad_id) : array
    {
        $user = Auth::guard('api')->user();
        if(!$user->favorites->where('ad_id', $ad_id)->first())
        {
            $message = "Ad not found in favorites";
            $code = 400;
            return [ 'data' => null, 'message' => $message, 'code' => $code ];
        }
        $data = $user->favorites->where('ad_id', $ad_id)->first();
        $data->delete();
        $message = "Ad removed from favorites successfully";
        $code = 200;
        return [ 'data' => null, 'message' => $message, 'code' => $code ];
    }

    public function IsInFavorites($ad_id) : array
    {

        $user = Auth::guard('api')->user();
        if($user->favorites->where('ad_id', $ad_id)->first() != null)
        {
            $message = "Ad found in favorites";
            $code = 200;
            return [ 'data' => 'true', 'message' => $message, 'code' => $code ];
        }
        else
        {
            $message = "Ad not found in favorites";
            $code = 200;
            return [ 'data' => 'false', 'message' => $message, 'code' => $code ];
        }
    }
    public function IsFavorite($ad_id)
    {

        $user = Auth::guard('api')->user();
        if(!$user)
            return false;
        if($user->favorites->where('ad_id', $ad_id)->first() != null)
        {
            return true;
        }
     return false;

    }
}
