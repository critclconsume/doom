<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display the public report form
     */
    public function create()
    {
        return view('pages.lapor');
    }

    /**
     * Store new laporan from public
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'telepon'     => 'required|string|max:20',
            'email'       => 'required|email|max:255',
            'lokasi'      => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'keterangan'  => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data['status'] = 'menunggu';

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('public/laporan', $filename);
            $data['foto'] = 'laporan/' . $filename;
        }

        $laporan = Laporan::create($data);

        return redirect()->route('beranda')
                         ->with('success', 'Laporan berhasil dikirim. Terima kasih atas partisipasinya!');
    }

    /**
     * List all reports (Admin)
     */
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

    /**
     * Update report status (Admin)
     */
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