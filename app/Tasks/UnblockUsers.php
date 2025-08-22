<?php

namespace App\Tasks;

use App\Models\Ad;
use App\Models\Block;

class UnblockUsers
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
        $threshold = now();
        Block::query()->where('end_date', '<', $threshold)->delete();

    }
}
