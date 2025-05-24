<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Responses\Response;
use Illuminate\Http\Request;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reviews = Review::all();
        return Response::Success($reviews,'All reviews returned successfully',200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'rating' => 'required|numeric|between:0,5',
            'comment' => 'required|string|max:65535',
        ]);

        $review = Review::create([
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
            'user_id' => $request->input('user_id'),
            'property_id' => $request->input('property_id'),
        ]);

        return Response::Success($review,'Review created successfully',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $review = Review::find($id);

        if (!$review) {
            return Response::Error([], 'Review not found', 404);
        }

        return Response::Success($review,'Review returned successfully',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $review = Review::find($id);

        if (!$review) {
            return Response::Error([], 'Review not found', 404);
        }

        $request->validate([
            'rating' => 'required|numeric|between:0,5',
            'comment' => 'required|string|max:65535',
        ]);

        $review->update([
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);
        return Response::Success($review,'Review updated successfully',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $review = Review::find($id);

        if (!$review) {
            return Response::Error([], 'Review not found', 404);
        }

        $review->delete();

        return Response::Success([],'Review deleted successfully',200);
    }
}
