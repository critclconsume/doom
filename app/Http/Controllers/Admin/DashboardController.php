<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Laporan;

class DashboardController extends Controller
{
public function index()
{
    // Laporan
    $laporanMenunggu = \App\Models\Laporan::where('status', 'menunggu')->count();
    $laporanDiterima = \App\Models\Laporan::where('status', 'diterima')->count();
    $laporanSelesai  = \App\Models\Laporan::where('status', 'selesai')->count();
    $laporanDitolak  = \App\Models\Laporan::where('status', 'ditolak')->count();
    $recentLaporan   = \App\Models\Laporan::latest()->take(5)->get();

    // Fasilitas
    $fasilitasBuka     = \App\Models\Fasilitas::where('status', 'open')->count();
    $fasilitasRenovasi = \App\Models\Fasilitas::where('status', 'maintenance')->count();
    $totalFasilitas    = $fasilitasBuka + $fasilitasRenovasi;
    $recentFasilitas   = \App\Models\Fasilitas::latest()->take(5)->get();

    // Proyek
    $proyekBerlangsung = \App\Models\Proyek::where('status', 'berlangsung')->count();
    $proyekPerencanaan = \App\Models\Proyek::where('status', 'perencanaan')->count();
    $proyekSelesai     = \App\Models\Proyek::where('status', 'selesai')->count();
    $recentProyek      = \App\Models\Proyek::latest()->take(5)->get();

    // Pengumuman
    $pengumumanPublished = \App\Models\Pengumuman::where('is_published', true)->count();
    $pengumumanDraft     = \App\Models\Pengumuman::where('is_published', false)->count();
    $recentPengumuman    = \App\Models\Pengumuman::latest('tanggal')->take(5)->get();

    return view('admin.mod', compact(
        'laporanMenunggu', 'laporanDiterima', 'laporanSelesai', 'laporanDitolak', 'recentLaporan',
        'totalFasilitas', 'fasilitasBuka', 'fasilitasRenovasi', 'recentFasilitas',
        'proyekBerlangsung', 'proyekPerencanaan', 'proyekSelesai', 'recentProyek',
        'pengumumanPublished', 'pengumumanDraft', 'recentPengumuman'
    ));
}
}