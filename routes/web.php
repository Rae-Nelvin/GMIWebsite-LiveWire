<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/gallery/{id}',[MainController::class,'gallery'])->name('gallery');

Route::group(['middleware' => [
    'auth:sanctum',
    'verified'
]], function() {

    Route::get('/admin/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/admin/galleries', function() {
        return view('admin.galleries');
    })->name('galleries');

    Route::get('/admin/news', function() {
        return view('admin.news');
    })->name('news');

    Route::get('/admin/admins', function() {
        return view('admin.admins');
    })->name('admins');

    Route::get('/admin/links', function() {
        return view('admin.links');
    })->name('links');

    Route::get('/admin/TTTRoles', function() {
        return view('admin.t-t-t-roles');
    })->name('TTTRoles');
    
});
