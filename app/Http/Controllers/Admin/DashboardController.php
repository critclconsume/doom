<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Fasilitas counts ──────────────────────────────────
        $totalFasilitas    = Fasilitas::count();
        $fasilitasBuka     = Fasilitas::where('status', 'open')->count();
        $fasilitasRenovasi = Fasilitas::where('status', 'maintenance')->count();

        // ── Laporan counts ────────────────────────────────────
        $totalLaporan    = Laporan::count();
        $laporanMenunggu = Laporan::where('status', 'menunggu')->count();
        $laporanDiterima = Laporan::where('status', 'diterima')->count();
        $laporanSelesai  = Laporan::where('status', 'selesai')->count();

        // ── Recent laporan (latest 5) ─────────────────────────
        $recentLaporan = Laporan::latest()->take(5)->get();

        return view('admin.mod', compact(
            'totalFasilitas',
            'fasilitasBuka',
            'fasilitasRenovasi',
            'totalLaporan',
            'laporanMenunggu',
            'laporanDiterima',
            'laporanSelesai',
            'recentLaporan'
        ));
    }
}
