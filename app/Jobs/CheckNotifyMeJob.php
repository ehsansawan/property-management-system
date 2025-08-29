<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\NotifyMe;
use App\Models\User;
use App\Services\AdService;
use App\Services\FcmService;
use http\Env\Request;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckNotifyMeJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $adService;
    protected $notificationService;
    public function __construct(AdService $adService,FcmService $notificationService)
    {
        //
        $this->adService = $adService;
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $nots=NotifyMe::query()->get();
        foreach($nots as $not)
        {
            $user=User::query()->find($not->user_id);
            $res=$this->adService->querySearch($not->filters)->get();
            if($res)
            {
                // ارسل ايميل
                $this->notificationService->
                sendNotification($user->fcm_token,'new notification','ad that you we looking for ',[
                    'ad'=>json_encode($res),
                ]);
            }
        }
    }
}
