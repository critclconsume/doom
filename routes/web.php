<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\PengumumanController;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'beranda'])->name('beranda');
Route::get('/proyek', [PageController::class, 'proyek'])->name('proyek');
Route::get('/panduan', [PageController::class, 'panduan'])->name('panduan');
Route::get('/lapor', [PageController::class, 'lapor'])->name('lapor');
Route::post('/lapor', [PageController::class, 'laporStore'])->name('lapor.store');

/*
|--------------------------------------------------------------------------
| Admin routes — protected by auth middleware only
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::patch('/laporan/{laporan}', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');

    // Fasilitas — full CRUD
    Route::resource('fasilitas', FasilitasController::class)->except(['show']);

    // Pengumuman — full CRUD
    Route::resource('pengumuman', PengumumanController::class)->except(['show']);
});