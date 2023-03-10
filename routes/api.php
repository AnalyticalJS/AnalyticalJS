<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Get Init Details
Route::post('/initDetails/', [App\Http\Controllers\Api\ApiFunctionController::class, 'initDetails'])->name('initDetails');
Route::get('/realtime/{id}', [App\Http\Controllers\Api\ApiFunctionController::class, 'realtime'])->name('realtime');