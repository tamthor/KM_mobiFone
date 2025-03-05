<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Events\MaintenanceModeEnabled;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('schedule:run', function () {
    Artisan::call('promotion:update-status');
})->daily(); // Hoặc everyDay() nếu muốn chạy hàng ngày

