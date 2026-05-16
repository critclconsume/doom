<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Laporan;

class DashboardController extends Controller
{
public function index()
{
    // Total Fasilitas
    $totalFasilitas = \App\Models\Fasilitas::count();
    $fasilitasBuka = \App\Models\Fasilitas::where('status', 'open')->count();
    $fasilitasRenovasi = \App\Models\Fasilitas::where('status', 'maintenance')->count();

    // Laporan Stats (Combined)
    $totalLaporan = \App\Models\Laporan::count();
    $laporanMenunggu = \App\Models\Laporan::where('status', 'menunggu')->count();
    $laporanDiterima = \App\Models\Laporan::where('status', 'diterima')->count();
    $laporanSelesai = \App\Models\Laporan::where('status', 'selesai')->count();
    $laporanDitolak = \App\Models\Laporan::where('status', 'ditolak')->count();

    $recentLaporan = \App\Models\Laporan::latest()->take(5)->get();

    return view('admin.mod', compact(
        'totalFasilitas', 
        'fasilitasBuka', 
        'fasilitasRenovasi',
        'totalLaporan',
        'laporanMenunggu',
        'laporanDiterima',
        'laporanSelesai',
        'laporanDitolak',
        'recentLaporan'
    ));
}
}