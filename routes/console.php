<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('rental:expire-payments', function () {
    $this->comment('Expired payments');
})->purpose('Expire payments');

Schedule::command('rental:expire-payments')->everyFiveMinutes();
