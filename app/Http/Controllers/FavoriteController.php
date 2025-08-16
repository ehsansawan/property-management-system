<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected FavoriteService $service;

    public function __construct(FavoriteService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data=[];
        try 
        {
            $data = $this->service->index();
            return Response::Success($data['data'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function add($ad_id)
    {
        $data = [];
        try 
        {
            $data = $this->service->add($ad_id);
            return Response::Success($data['data'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function remove($ad_id)
    {
        $data = [];
        try 
        {
            $data = $this->service->remove($ad_id);
            return Response::Success($data['data'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function IsInFavorites($ad_id)
    {
        $data = [];
        try 
        {
            $data = $this->service->IsInFavorites($ad_id);
            return Response::Success($data['data'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }
}
