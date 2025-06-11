<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function show($id = null) : array
    {
        //$request = new Request($req);
        $res = [];
        $user = Auth::guard('api')->user();
        if($id == null)
        {
            $last_subscription = $user->subscriptions->where('status', 'active')->get();
        }
        else
        {

        }
    }
}
