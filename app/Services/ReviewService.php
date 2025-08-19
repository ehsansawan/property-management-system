<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    /**
     * Create a new class.
     */
    public function __construct()
    {
    }

    public function index()
    {
        $reviews = Review::all();
        $message ='reviews retrieved successfully';
        $code = 200;
        return ['reviews' => $reviews, 'message' => $message, 'code' => $code];
    }

    public function user_store($req) : array
    {
        $request = new Request($req);

        $review = Review::create([
            'ad_id' => $request->input('ad_id'),
            'user_id'     => Auth::guard('api')->user()->id,
            'comment'     => $request->input('comment'),
            'rating'      => $request->input('rating'),
        ]);


        if(is_null($review))
        {
            $message = 'review can not be created, try again later';
            $code = 400;
            return ['review' => null, 'message' => $message,'code' => $code];
        }

        $message = 'review created successfully'; $code = 200;
        return ['review' => $review, 'message' => $message, 'code' => $code];
    }

    public function show($id) : array
    {
        $review = Review::find($id);

        if (!$review)
        {
            $message = 'review not found';    $code = 404;
            return ['review' => null, 'message' => $message, 'code' => $code];
        }

        $message = 'review retrieved successfully';
        $code = 200;
        return ['review' => $review, 'message' => $message, 'code' => $code];
    }

    public function user_update($req, $id) : array
    {
        $request = new Request($req);

        $review = Review::find($id);

        if (!$review)
        {
            $message = 'review not found';  $code = 404;
            return ['review' => null, 'message' => $message, 'code' => $code];
        }

        if($review->user_id != Auth::guard('api')->user()->id)
        {
            $message = 'you are not authorized to update this review';  $code = 403;
            return ['review' => null, 'message' => $message, 'code' => $code];
        }

        $updateData = array_filter([
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating')
        ], function($value) {return $value !== null;});

        $review->update($updateData);

        $message = 'review updated successfully'; $code = 200;
        return ['review' => $review, 'message' => $message, 'code' => $code];
    }

    public function destroy($id) : array
    {
        $review = Review::find($id);

        if (!$review)
        {
            $message = 'review not found';  $code = 404;
            return ['review' => null, 'message' => $message, 'code' => $code];
        }

        $review->delete();
        $message = 'review deleted successfully';  $code=200;
        return ['review' => null, 'message' => $message,'code' => $code];
    }

    public function client_destroy($id) : array
    {
        $review = Review::find($id);

        if (!$review)
        {
            $message = 'review not found';  $code = 404;
            return ['review' => null, 'message' => $message, 'code' => $code];
        }

        if($review->user_id != Auth::guard('api')->user()->id)
        {
            $message = 'you are not authorized to delete this review';  $code = 403;
            return ['review' => null, 'message' => $message, 'code' => $code];
        }

        $review->delete();
        $message = 'review deleted successfully';  $code=200;
        return ['review' => null, 'message' => $message,'code' => $code];
    }

    public function ad_index($ad_id) : array
    {
        $reviews = Review::query()->with(['user.profile'])->where('ad_id', $ad_id)->get();
        $message = 'reviews retrieved successfully'; $code = 200;
        return ['reviews' => $reviews, 'message' => $message, 'code' => $code];
    }

}
