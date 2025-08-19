<?php

namespace App\Http\Controllers;

use Throwable;
use App\Services\ReviewService;
use App\Http\Responses\Response;
use App\Http\Requests\Review\CreateReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;


class ReviewController extends Controller
{

    protected ReviewService $service; 

    public function __construct(ReviewService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[];
        try 
        {
            $data=$this->service->index();
            return Response::Success($data['reviews'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    /**
     * Store a newly created review by a specific user in storage.
     */
    public function user_store(CreateReviewRequest $request)
    {
        $data = [];
        try
        {
            $data = $this->service->user_store($request->validated());
            return Response::Success($data['review'], $data['message'], $data['code']);
        } 
        catch (Throwable $th) 
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [];
        try 
        {
            $data=$this->service->show($id);
            return Response::Success($data['review'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message=$th->getMessage();
            return Response::Error($data, $message);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function user_update(UpdateReviewRequest $request, string $id)
    {
        $data = [];
        try
        {
            $data = $this->service->user_update($request->validated(), $id);
            return Response::Success($data['review'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message=$th->getMessage();
            return Response::Error($data, $message);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=[];
        try 
        {
            $data = $this->service->destroy($id);
            return Response::Success($data['review'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message=$th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function client_destroy(string $id)
    {
        $data = [];
        try {
            $data = $this->service->client_destroy($id);
            return Response::Success($data['review'], $data['message'], $data['code']);
        }
        catch (Throwable $th) {
            $message=$th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function ad_index(string $ad_id)
    {
        $data = [];
        try {
            $data = $this->service->ad_index($ad_id);
            return Response::Success($data['reviews'], $data['message'], $data['code']);
        }
        catch (Throwable $th) { 
            $message=$th->getMessage();
            return Response::Error($data, $message);
        }
    }
}
