<?php

namespace App\Services;

use App\Models\Block;
use App\Models\User;
use Carbon\Carbon;

class BlockService
{
    /**
     * Create a new class instance.
     */
    public function DamascusTime($block)
    {
        $block['start_date']=$block['start_date']->timezone('Asia/Baghdad')->subHour(10);
        $block['end_date']=$block['end_date']->timezone('Asia/Baghdad')->subHour(10);
        return $block;
    }
    public function __construct()
    {
        //
    }

    public function block($request)
    {
        $user=auth()->user();
        $user_to_block=User::find($request['blocked_id']);

        if($user->hasRole('super_admin'))
        {
            if($user_to_block->hasRole('super_admin'))
            {
                return ['block'=>null,'message'=>'u cant block super admin','code'=>403];
            }
        }
        else // if he is admin
        {
            if($user_to_block->hasRole('super_admin') || $user_to_block->hasRole('admin'))
                return ['block'=>null,'message'=>'u cant block super admin or admin','code'=>403];
        }

        //first u have to check that the role of blocker id is admin


        $block=Block::query()->create([
            'blocker_id'=>auth('api')->id(),
            'blocked_id'=>$request['blocked_id'],
            'start_date'=>Carbon::now(),
            'end_date'=>Carbon::now()->addDays((integer)$request['days']??7),
            'reason'=>$request['reason']??null,
        ]);

       // $block=$block->refresh();
        $block=$this->DamascusTime($block);

        $message='u block user successfully';
        $code=200;
        return ['block'=>$block,'message'=>$message,'code'=>$code];

    }
    public function unblock($id)
    {


        $block=Block::query()->find($id);
        if(!$block)
        {
            $message=' block not found';
            $code=404;
            return ['block'=>$block,'message'=>$message,'code'=>$code];
        }

        $block->delete();

        $code=200;
        return ['block'=>$block,'message'=>'u unblock user successfully','code'=>$code];
    }
    public function index()
    {
        $blocks=Block::query()->with(['blocker','blocked'])->get();
        return ['blocks'=>$blocks,'message'=>'blocks retrieved successfully','code'=>200];
    }


}
