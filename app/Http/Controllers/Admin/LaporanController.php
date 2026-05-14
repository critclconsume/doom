<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::latest()->paginate(15);
        return view('admin.laporan.lain', compact('laporan'));
    }

    public function show(Laporan $laporan)
    {
        return view('admin.laporan.lain', compact('laporan'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diterima,selesai'
        ]);

        $laporan->update(['status' => $validated['status']]);

        return redirect()->route('admin.laporan.lain')
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