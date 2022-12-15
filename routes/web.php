<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\JadwalKegiatanController;
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

    //sekolah
    Route::get('/data-sekolah', [SekolahController::class, 'datasekolah'])->name('data-sekolah');
    Route::post('/save-school', [SekolahController::class, 'simpansekolah']);
    Route::post('/update-school/{NPSN}', [SekolahController::class, 'updatesekolah']);
    Route::get('/delete-school/{NPSN}', [SekolahController::class, 'hapussekolah']);

    //prodi
    Route::get('/data-prodi', [ProgramStudiController::class, 'dataprodi'])->name('data-prodi');
    Route::post('/save-prodi', [ProgramStudiController::class, 'simpanprodi']);
    Route::post('/update-prodi/{id_prodi}', [ProgramStudiController::class, 'updateprodi']);
    Route::get('/delete-prodi/{id_prodi}', [ProgramStudiController::class, 'hapusprodi']);

    //jadwal
    Route::get('/data-jadwal', [JadwalKegiatanController::class, 'datajadwal'])->name('data-jadwal');
    Route::post('/save-jadwal', [JadwalKegiatanController::class, 'simpanjadwal']);
    Route::post('/update-jadwal/{id}', [JadwalKegiatanController::class, 'updatejadwal']);
    Route::get('/delete-jadwal/{id}', [JadwalKegiatanController::class, 'hapusjadwal']);
});

require __DIR__.'/auth.php';
