<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\User\MainController;
use App\Http\Controllers\User\Auth\AuthenticatedSessionController;

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

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/gallery/{id}',[IndexController::class,'gallery'])->name('gallery');

Route::group(['middleware' => 'auth'], function() {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::group(['middleware' => 'verified'], function() {

        Route::get('/dashboard', [MainController::class, 'index'])->name('dashboard');
    
    });

});