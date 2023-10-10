<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reloadCache', function () { App\Console\Command::reloadCache($this); })->purpose('Reload database into cache.');
Artisan::command('countHourly', function () { App\Console\Command::countHourly($this); })->purpose('Counts the hourly website stats.');
Artisan::command('countDupes', function () { App\Console\Command::countDupes($this); })->purpose('Counts the duplicates and saves it.');