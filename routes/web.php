<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\PengumumanController;
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
Route::get('/proyek', [PageController::class, 'proyek'])->name('proyek');
Route::get('/panduan', [PageController::class, 'panduan'])->name('panduan');

// Laporan Public
Route::get('/lapor', [PageController::class, 'lapor'])->name('lapor');
Route::post('/lapor', [PageController::class, 'laporStore'])->name('lapor.store');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
// Admin Fasilitas Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('fasilitas', Admin\FasilitasController::class)
         ->parameters([
             'fasilitas' => 'fasilitas'  
         ]);
    Route::get('/fasilitas', FasilitasController::class, 'index')->name('fasilitas.index');
    Route::patch('/fasilitas/create', FasilitasController::class, 'create')->name('fasilitas.create');
    Route::post('/fasilitas/store', FasilitasController::class, 'store')->name('fasilitas.store');
    Route::post('/fasilitas/edit', FasilitasController::class, 'edit')->name('fasilitas.edit');
    Route::post('/fasilitas/update', FasilitasController::class, 'update')->name('fasilitas.update');
    Route::post('/fasilitas/destroy', FasilitasController::class, 'destroy')->name('fasilitas.destroy');
});
    // Login Routes (Public)
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Laporan Admin
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::patch('/laporan/{laporan}', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
        Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class)
         ->only(['index', 'show', 'destroy']);
    
    Route::patch('laporan/{laporan}/status', [App\Http\Controllers\Admin\LaporanController::class, 'updateStatus'])
         ->name('admin.laporan.status');

        // Fasilitas
        Route::resource('fasilitas', FasilitasController::class)->except(['show']);

        // Pengumuman
        Route::resource('pengumuman', PengumumanController::class)->except(['show']);
    });

require __DIR__.'/auth.php';