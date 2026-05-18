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

    public function show(Laporan $laporan)
    {
        return view('admin.laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        return view('admin.laporan.edit', compact('laporan'));
    }

    /**
     * Update Laporan (digunakan dari halaman edit)
     */
    public function update(Request $request, Laporan $laporan)
    {
$request->validate([
    'status' => 'required|in:menunggu,diterima,selesai,ditolak',
]);

        $laporan->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.laporan.show', $laporan)
            ->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
    'status' => 'required|in:menunggu,diterima,selesai,ditolak',
]);

        $laporan->update(['status' => $request->status]);

        return redirect()->route('admin.laporan.index')
                         ->with('success', 'Status laporan berhasil diperbarui.');
    }

public function destroy(Laporan $laporan)
{
    // Delete new-style photos (public/images/laporan/)
    if ($laporan->fotos) {
        foreach ($laporan->fotos as $filename) {
            $path = public_path('images/laporan/' . $filename);
            if (file_exists($path)) unlink($path);
        }
    }

    // Delete old single photo (storage)
    if ($laporan->foto) {
        $path = storage_path('app/public/' . $laporan->foto);
        if (file_exists($path)) unlink($path);
    }

    $laporan->delete();

    return redirect()->route('admin.laporan.index')
                     ->with('success', 'Laporan berhasil dihapus.');
}
}