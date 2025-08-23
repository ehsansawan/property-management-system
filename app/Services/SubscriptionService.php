<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    public function __construct()
    {
    }

    /***********************************************************
    *                        for admin                         *
    ************************************************************/
    
    public function allActiveSub() : array
    {
        $subs = Subscription::query()->where('status', 'active')->get();
        $message = "Active Subscriptions Retrieved Successfully";
        return ['subscription' => $subs,'message'=> $message,'code'=>200];
    }

    public function deactivate($sub_id) : array
    {
        $sub = Subscription::query()->find($sub_id);
        if(!$sub)
        {
            $message   = "Subscription not found"; 
            return ['subscription' => null,'message' =>$message, 'code'  =>404];
        }
        $sub->status = 'expired';
        $sub->save();
        $message = "Subscription deactivated successfully"; 
        return ['subscription' =>$sub,'message' => $message, 'code'=>200];
    }
    
    public function index() : array
    {
        $subs = Subscription::with(['user.profile', 'plan'])->get();
        $message = "Subscriptions retrieved successfully"; 
        return ['subscription' => $subs,'message' => $message, 'code' => 200];
    }

    public function show($sub_id) : array
    {
        $sub = Subscription::query()->find($sub_id);
        if(!$sub)
        {
            $message = "Subscription not found"; $code  =  404;
            return ['subscription' => null,'message' =>$message, 'code'  => $code];
        }

        $message  = "Subscription retrieved successfully"; 
        return ['subscription' => $sub,'message' =>$message, 'code' => 200];
    }

    public function destroy($sub_id)
    {
        $sub = Subscription::query()->find($sub_id);
        if(!$sub)
        {
            $message = "Subscription not found"; $code   = 404; 
            return ['subscription' => null, 'message' => $message, 'code' => $code];
        }
        $sub->delete();
        $message   = "Subscription deleted successfully"; 
        return ['subscription' => null, 'message' => $message, 'code' => 200];
    }

    /***********************************************************
    *                         for user                         *
    ************************************************************/

    public function userActiveSub() : array
    {
        $user = Auth::guard('api')->user();
        if(!$user->subscriptions)
        {
            $message = "No active subscription"; $code = 204;
            return ['subscription' => null, 'message' => $message, 'code' => $code];
        }
        $sub = $user->subscriptions->where('status', 'active')->first();
        
        if(!$sub)
        {
            $data = null; $message = "No active subscription"; $code = 204;
            return ['subscription' => $sub, 'message' => $message, 'code' => $code];
        }
        
        $message = "Active subscription retrieved successfully";
        return ['subscription' => $sub, 'message' => $message, 'code' => 200];
    }
    
    public function userDeactivate() : array
    {
        $user = Auth::guard('api')->user();
        $subs = Subscription::query()->where(['status'=>'active','user_id'=>$user->id])->first();
        if(!$subs)
        {
            $message = "Subscription not found"; 
            return ['subscription' => null, 'message' =>$message, 'code'=>404];
        }
        $subs->status  = 'expired';
        $subs->save();
        $message = "Subscription deactivated successfully"; 
        return ['subscription'=>$subs, 'message' => $message, 'code' => 200];
    }

    public function userIndex() : array
    {
        $user = Auth::guard('api')->user();
        $subs = $user->subscriptions;
        $message = "Subscriptions retrieved successfully"; 
        return ['subscription' => $subs,'message'=>$message, 'code'=>200];
    }

    public function userShow($sub_id) : array
    {
        $user = Auth::guard('api')->user();
        $sub = $user->subscriptions->find($sub_id);
        if(!$sub)
        {
            $message  = "Subscription not found"; 
            return ['subscription' => null, 'message'=> $message, 'code' => 404];
        }
        $message  = "Subscription retrieved successfully"; 
        return ['subscription' => $sub, 'message' => $message, 'code' => 200];
    }

    public function userCreate($req) : array
    {
        $request = new Request($req);
        $user = Auth::guard('api')->user();
        $plan = Plan::find($request->input('plan_id'));
        $sub = new Subscription;
        $sub->user()->associate($user);
        $sub->plan()->associate($plan);
        $sub->start_date  = date("Y-m-d");
        $sub->end_date    = date('Y-m-d', strtotime("+{$plan->duration} months"));
        $sub->status      = 'active';
        $sub->save();
        $message   = "Subscription created successfully"; 
        return ['subscription' => $sub, 'message' => $message, 'code' => 201];
    }

    public function time_remaining($sub_id) : array
    {
        $user = Auth::guard('api')->user();
        $subs = $user->subscriptions;
        $sub = $subs->find($sub_id);
        if (!$sub)      {
            $message    = 'Subscription not found';
            $code       =  404;
            return      ['time' => null, 'message' => null,'code' => $code];
        }

        $today      = strtotime(date('Y-m-d'));
        $end_date   = strtotime($sub->end_date);
        if($today > $end_date) {
            return ['time' => null,'message' =>'subscription expired', 'code' => 419];
        }
        $diff       = ($end_date - $today) / (60 * 60 * 24);
        $message    = "{$sub->plan->name} subscription will expire in {$diff} days";
        $code       = 200;
        return ['time' => $diff, 'message' => $message, 'code' => $code];
    }
}
