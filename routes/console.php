<?php

use App\Tasks\CleanNotifyMeTable;
use App\Tasks\DeactivateExpiredAds;
use App\Tasks\UnblockUsers;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(new DeactivateExpiredAds)->everyThirtyMinutes();
Schedule::call(new UnblockUsers())->everyFourMinutes();
Schedule::call(new CleanNotifyMeTable())->everySixHours();
