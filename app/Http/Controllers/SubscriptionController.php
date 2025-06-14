<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriptionRequest;
use Throwable;
use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    protected SubscriptionService $service;
    public function __construct(SubscriptionService $service)
    {
        $this->service = $service;
    }

    /***********************************************************
    *                        for admin                         *
    ************************************************************/


    public function allActiveSub()
    {
        $data=[];
        try {
            $data = $this->service->allActiveSub();
            return Response::Success($data['subscription'], $data['message'], $data['code']);
        } catch (Throwable $th) {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function deactivate($sub_id)
    {
        $data = [];
        try {
            $data = $this->service->deactivate($sub_id);
            return Response::Success($data['subscription'], $data['message'], $data['code']);
        } catch (Throwable  $th) {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function index()
    {
        $data = [];
        try {
            $data = $this->service->index();
            return Response::Success($data['subscription'], $data['message'], $data['code']);
        } catch (Throwable   $th) {
            $message  = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function show($sub_id)
    {
        $data = [];
        try {
            $data = $this->service->show($sub_id);
            return Response::Success($data['subscription'], $data['message'], $data['code']);
        } catch (Throwable  $th) {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function destroy($sub_id)
    {
        $data = [];
        try {
            $data = $this->service->destroy($sub_id);
            return Response::Success($data['subscription'], $data['message'], $data['code']);
        } catch (Throwable   $th) {
            $message  = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    /***********************************************************
    *                         for user                         *
    ************************************************************/


    public function userActiveSub()
    {
        $data  = [];
        try {
            $data   = $this->service->userActiveSub();
            return Response::Success($data['subscription'], $data['message'], $data['code']);
        } catch (Throwable    $th) {
            $message   = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function userDeactivate()
    {
        $data   = [];
        try {
            $data    = $this->service->userDeactivate();
            return Response::Success($data['subscription'], $data['message'], $data['code']);
        } catch (Throwable     $th) {
            $message   = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function userIndex()
    {
        $data    = [];
        try {
            $data    = $this->service->userIndex();
            return Response::Success($data['subscriptions'], $data['message'], $data['code']);
        } catch (Throwable      $th) {
            $message    = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function userShow($sub_id)
    {
        $data    = [];
        try {
            $data    = $this->service->userShow($sub_id);
            return Response::Success($data['subscription'], $data['message'], $data['code']);
        } catch (Throwable      $th) {
            $message    = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function userCreate(CreateSubscriptionRequest $req)
    {
        $data    = [];
        try {
            $data   = $this->service->userCreate($req->validated());
            return Response::Success($data['subscription'],  $data['message'], $data['code']);
        } catch (Throwable       $th) {
            $message    = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function time_remaining($sub_id)
    {
        $data     = [];
        try {
            $data   = $this->service->time_remaining($sub_id);
            return Response::Success($data['time'],  $data['message'], $data['code']);
        } catch (Throwable        $th) {
            $message    = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

}
