<?php

namespace App\Console\Commands;

use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeativateExpiredAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deativate-expired-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate Expired Ads that are order than 3 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = now()->subDays(3);

        Ad::query()->where('is_active', true)
            ->where('start_date', '<=', $threshold)
            ->update(['is_active' => false]);

        $this->info("Expired ads older than 3 days (to the second) have been deactivated.");
    }
}
