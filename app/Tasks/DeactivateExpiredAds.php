<?php

namespace App\Tasks;

use App\Models\Ad;

class DeactivateExpiredAds
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
        $threshold = now()->subDays(3);

        Ad::query()->where('is_active', true)
            ->where('start_date', '<=', $threshold)
            ->update(['is_active' => false]);
    }
}
