<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');

        $query = Laporan::latest();

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $laporan = $query->paginate(15);

        // Count per status for filter tabs
        $counts = [
            'menunggu' => Laporan::where('status', 'menunggu')->count(),
            'diterima' => Laporan::where('status', 'diterima')->count(),
            'selesai'  => Laporan::where('status', 'selesai')->count(),
        ];

        return view('admin.laporan.index', compact('laporan', 'counts', 'status'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:diterima,selesai',
        ]);

        $laporan->update(['status' => $request->status]);

        $label = $request->status === 'selesai' ? 'selesai' : 'diterima';

        return back()->with('success', "Laporan dari {$laporan->nama} ditandai sebagai {$label}.");
    }
}
