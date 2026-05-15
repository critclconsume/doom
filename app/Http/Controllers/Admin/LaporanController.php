<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $status = request('status', 'semua');

        $query = Laporan::latest();
        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $laporan = $query->paginate(15);

        $counts = [
            'menunggu' => Laporan::where('status', 'menunggu')->count(),
            'diterima' => Laporan::where('status', 'diterima')->count(),
            'selesai'  => Laporan::where('status', 'selesai')->count(),
        ];

        return view('admin.laporan.lain', compact('laporan', 'counts'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diterima,selesai',
        ]);

        $laporan->update(['status' => $request->status]);

        return redirect()->route('admin.laporan.index')
                         ->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        if ($laporan->foto) {
            $path = storage_path('app/public/' . $laporan->foto);
            if (file_exists($path)) unlink($path);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')
                         ->with('success', 'Laporan berhasil dihapus.');
    }
}