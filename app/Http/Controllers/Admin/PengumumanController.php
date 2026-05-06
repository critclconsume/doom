<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest('tanggal')->paginate(15);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'tanggal'      => 'required|date',
            'is_published' => 'nullable|boolean',
        ], [
            'judul.required'   => 'Judul pengumuman wajib diisi.',
            'isi.required'     => 'Isi pengumuman wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
        ]);

        $validated['is_published'] = $request->has('is_published');

        Pengumuman::create($validated);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', "Pengumuman \"{$validated['judul']}\" berhasil ditambahkan.");
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.form', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'tanggal'      => 'required|date',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $pengumuman->update($validated);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', "Pengumuman \"{$pengumuman->judul}\" berhasil diperbarui.");
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $judul = $pengumuman->judul;
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', "Pengumuman \"{$judul}\" berhasil dihapus.");
    }
}
