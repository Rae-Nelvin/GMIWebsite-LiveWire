<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MainController;

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

Route::group(['as' => 'admin.'], function() {
    Route::group(['middleware' => 'auth:admin'], function() {

        Route::get('/dashboard', [MainController::class, 'index'])->name('dashboard');
        Route::get('/galleries', function() {
            return view('admin.galleries');
        })->name('galleries');
        Route::get('/news', function() {
            return view('admin.news');
        })->name('news');
        Route::get('/admins', function() {
            return view('admin.admins');
        })->name('admins');
        Route::get('/links', function() {
            return view('admin.links');
        })->name('links');
        Route::get('/TTTRoles', function() {
            return view('admin.t-t-t-roles');
        })->name('TTTRoles');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    });

    Route::group(['middleware' => 'guest:admin'], function() {

        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

    });

});
    