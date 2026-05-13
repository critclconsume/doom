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

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('/beranda', [PageController::class, 'beranda'])->name('beranda');
Route::get('/proyek',  [PageController::class, 'proyek']) ->name('proyek');
Route::get('/panduan', [PageController::class, 'panduan'])->name('panduan');
Route::get('/lapor',   [PageController::class, 'lapor'])  ->name('lapor');
Route::post('/lapor',  [PageController::class, 'laporStore'])->name('lapor.store');


Route::get('/', function () {
         return view('welcome');
 });
Route::get('/admin', function () {
    return view('admin.mod');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin routes — protected by auth middleware (Breeze/Jetstream)
|--------------------------------------------------------------------------
/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // === PUBLIC LOGIN ROUTES (no middleware) ===
    Route::get('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

    // === PROTECTED ROUTES (only for logged in admin) ===
    Route::middleware(['auth', 'verified'])->group(function () {

       Route::get('/', [DashboardController::class, 'index'])->name('beranda');
       Route::get('/', [App\Http\Controllers\PageController::class, 'beranda'])->name('beranda');
       // Public Routes
Route::get('/lapor', [App\Http\Controllers\Admin\LaporanController::class, 'create'])->name('laporan.create');
Route::post('/lapor', [App\Http\Controllers\Admin\LaporanController::class, 'store'])->name('laporan.store');

//user page
Route::get('/beranda', function () {
    return view('pages.beranda');
})->name('main');
Route::get('/proyek', function () {
    return view('pages.proyek');
})->name('proyek');
Route::get('/panduan', function () {
    return view('pages.panduan');
})->name('panduan');
Route::get('/lapor', function () {
    return view('pages.lapor');
})->name('lapor');
})->middleware(['auth', 'verified'])->name('admin');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::patch('/laporan/{laporan}', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');

        // Fasilitas
        Route::resource('fasilitas', FasilitasController::class)->except(['show']);

        // Pengumuman
        Route::resource('pengumuman', PengumumanController::class)->except(['show']);

        // Logout
        Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
require __DIR__.'/auth.php';