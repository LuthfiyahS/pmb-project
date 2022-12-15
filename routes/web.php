<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return view('welcome');
});

/**
 * socialite auth
 */
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');    

    //user/pengguna
    Route::get('/data-user', [UserController::class, 'datauser'])->name('data-user');
    Route::post('/save-user', [UserController::class, 'simpanuser']);
    Route::get('/data-user/edit/{user_id}', [UserController::class, 'edituser']);
    Route::post('/update-user/{user_id}', [UserController::class, 'updateuser']);
    Route::get('/data-user/delete/{user_id}', [UserController::class, 'hapususer']);

});

require __DIR__.'/auth.php';
