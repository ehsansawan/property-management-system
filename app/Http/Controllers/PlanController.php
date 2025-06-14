<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Services\PlanService;
use App\Http\Responses\Response;
use App\Http\Requests\Plan\CreatePlanRequest;
use App\Http\Requests\Plan\UpdatePlanRequest;


class PlanController extends Controller
{
    protected PlanService $service;

    public function __construct(PlanService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data=[];
        try 
        {
            $data = $this->service->index();
            return Response::Success($data['plan'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function show(string $id)
    {
        $data = [];
        try 
        {
            $data = $this->service->show($id);
            return Response::Success($data['plan'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function destroy(string $id)
    {
        $data = [];
        try 
        {
            $data = $this->service->destroy($id);
            return Response::Success($data['plan'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function store(CreatePlanRequest $request)
    {
        $data = [];
        try 
        {
            $data = $this->service->store($request->validated());
            return Response::Success($data['plan'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function update(UpdatePlanRequest $request, string $id)
    {
        $data = [];
        try 
        {
            $data = $this->service->update($request->validated(), $id);
            return Response::Success($data['plan'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function getYearlyPlans()
    {
        $data = [];
        try 
        {
            $data = $this->service->getYearlyPlans();
            return Response::Success($data['plan'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function getMonthlyPlans()
    {
        $data = [];
        try 
        {
            $data = $this->service->getMonthlyPlans();
            return Response::Success($data['plan'], $data['message'], $data['code']);
        }
        catch (Throwable $th)
        {
            $message = $th->getMessage();
            return Response::Error($data, $message);
        }
    }
}
