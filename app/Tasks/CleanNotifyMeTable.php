<?php

namespace App\Tasks;

use App\Models\Ad;
use App\Models\Block;
use App\Models\NotifyMe;
use Carbon\Carbon;

class CleanNotifyMeTable
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function __invoke()
    {

        $weekAgo = Carbon::now()->subWeek();

        $deleted = NotifyMe::query()
            ->where('created_at', '<', $weekAgo)
            ->delete();
    }
}
