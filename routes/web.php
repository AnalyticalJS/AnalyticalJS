<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Homepage Routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');

// Site pages
Route::get('/site/{domain?}', [App\Http\Controllers\SitesController::class, 'site'])->name('site');


// Auth Routes
Auth::routes();

// Pages Controller
Route::get('/details', [App\Http\Controllers\PagesController::class, 'details'])->name('details');

#Routes all the User system
Route::resource('/user', UserController::class);