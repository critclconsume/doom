<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index()
    {
        $proyek = Proyek::latest()->paginate(15);
        return view('admin.proyek.prain', compact('proyek'));
    }

    public function create()
    {
        return view('admin.proyek.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'lokasi'          => 'required|string|max:255',
            'status'          => 'required|in:berlangsung,perencanaan,selesai',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        Proyek::create($validated);

        return redirect()->route('admin.proyek.index')
                         ->with('success', "Proyek \"{$validated['nama']}\" berhasil ditambahkan.");
    }

    public function edit(Proyek $proyek)
    {
        return view('admin.proyek.form', compact('proyek'));
    }

    public function update(Request $request, Proyek $proyek)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'lokasi'          => 'required|string|max:255',
            'status'          => 'required|in:berlangsung,perencanaan,selesai',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $proyek->update($validated);

        return redirect()->route('admin.proyek.index')
                         ->with('success', "Proyek \"{$proyek->nama}\" berhasil diperbarui.");
    }

    public function destroy(Proyek $proyek)
    {
        $nama = $proyek->nama;
        $proyek->delete();

        return redirect()->route('admin.proyek.index')
                         ->with('success', "Proyek \"{$nama}\" berhasil dihapus.");
    }
}