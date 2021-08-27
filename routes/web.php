<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => [
    'auth:sanctum',
    'verified'
]], function() {

    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

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
    
});
