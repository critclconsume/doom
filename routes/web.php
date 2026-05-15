<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\ProyekController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('beranda');
});

Route::get('/beranda', [PageController::class, 'beranda'])->name('beranda');
Route::get('/proyek',  [PageController::class, 'proyek'])->name('proyek');
Route::get('/panduan', [PageController::class, 'panduan'])->name('panduan');

// Laporan Public
Route::get('/lapor', [PageController::class, 'lapor'])->name('lapor');
Route::post('/lapor', [PageController::class, 'laporStore'])->name('lapor.store');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // === LOGIN ROUTES (Public - No Auth Required) ===
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // === PROTECTED ADMIN ROUTES ===
    Route::middleware('auth')->group(function () {

        // Dashboard (utama)
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Mod Dashboard (jika ingin akses langsung /admin/mod)
        Route::get('/mod', [DashboardController::class, 'index'])->name('mod');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::patch('/laporan/{laporan}', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');

        // Fasilitas
        Route::resource('fasilitas', FasilitasController::class)->except(['show']);

        // Pengumuman
        Route::resource('pengumuman', PengumumanController::class)->except(['show']);

        // Proyek
        Route::resource('proyek', ProyekController::class)->except(['show']);

        // Logout
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});

require __DIR__.'/auth.php';