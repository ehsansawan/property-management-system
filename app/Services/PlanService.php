<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    public function index() : array
    {
        $reviews = Plan::all();
        $message ='plans retrieved successfully';
        $code = 200;
        return ['plans' => $reviews, 'message' => $message, 'code' => $code];
    }

    public function show($plan_id) : array
    {
        $plan = Plan::query()->find($plan_id);

        if (!$plan) 
        {
            $message = 'plan not found';    $code = 404;
            return ['plan' => null, 'message' => $message, 'code' => $code];
        }

        $message = 'plan retrieved successfully';   $code = 200;
        return ['plan' => $plan, 'message' => $message, 'code' => $code];
    }

    public function update($req, $plan_id) : array
    {
        $request = new Request($req);

        $plan = Plan::query()->find($plan_id);

        if (!$plan)
        {
            $message = 'plan not found';  $code = 404;
            return ['plan' => null, 'message' => $message, 'code' => $code];
        }

        $updateData = array_filter([
            'name'     => $request->input('name'),
            'price'    => $request->input('price'),
            'type'     => $request->input('type'),
            'features' => $request->input('features'),
            'duration' => $request->input('duration'),
        ], function($value) {return $value !== null;});

        $plan->update($updateData);

        $message = 'plan updated successfully';         $code = 200;
        return ['plan' => $plan, 'message' => $message, 'code' => $code];
    }

    public function store($req) : array
    {
        $request = new Request($req);
        $plan = Plan::query()->create([
            'name'     => $request->input('name'),
            'price'    => $request->input('price'),
            'type'     => $request->input('type'),
            'features' => $request->input('features'),
            'duration' => $request->input('duration'),
        ]);

        if(is_null($plan))
        {
            $message = 'plan can not be created, try again later';  $code = 400;
            return ['plan' => null, 'message' => $message,'code' => $code];
        }

        $message = 'plan created successfully';  $code = 200;
        return ['plan' => $plan, 'message' => $message, 'code' => $code];
    }

    public function destroy($plan_id) : array
    {
        $plan = Plan::query()->find($plan_id);

        if (!$plan)
        {
            $message = 'plan not found';  $code = 404;
            return ['plan' => null, 'message' => $message, 'code' => $code];
        }

        $plan->delete();
        $message = 'plan deleted successfully';     $code = 200;
        return ['plan' => null, 'message' => $message, 'code' => $code];
    }

    /**
     * Retrieve all yearly plans.
     *
     * @return array
     */
    public function getYearlyPlans() : array
    {
        $plans = Plan::query()->where('type', 'yearly')->get();
        
        $message = 'plans retrieved successfully';  $code = 200;
        return ['plans' => $plans, 'message' => $message, 'code' => $code];
    }

    public function getMonthlyPlans() : array
    {
        $plans = Plan::query()->where('type', 'monthly')->get();

        $message = 'plans retrieved successfully';  $code = 200;
        return ['plans' => $plans, 'message' => $message, 'code' => $code];
    }
}
