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
Route::get('/initDetails/', [App\Http\Controllers\Api\ApiFunctionController::class, 'initDetails'])->name('initDetails');

// Unnmount
Route::get('/unmount/{id}', [App\Http\Controllers\Api\ApiFunctionController::class, 'unmount'])->name('unmount');
