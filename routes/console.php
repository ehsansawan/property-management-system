<?php

use App\Tasks\DeactivateExpiredAds;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(new DeactivateExpiredAds)->everyFifteenSeconds(); // أو daily، أو كل دقيقة للتجربة
