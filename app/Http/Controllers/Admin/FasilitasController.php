<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::latest()->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('admin.fasilitas.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'address' => 'required|string|max:200',
            'type'    => 'required|string',
            'status'  => 'required|in:open,maintenance',
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'name.required'    => 'Nama fasilitas wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'type.required'    => 'Tipe fasilitas wajib dipilih.',
            'status.required'  => 'Status wajib dipilih.',
            'photo.image'      => 'File harus berupa gambar.',
            'photo.max'        => 'Ukuran foto maksimal 5 MB.',
        ]);

        // Handle photo upload → public/images/fasilitas/
        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('images/fasilitas'), $filename);
            $validated['photo'] = $filename;
        }

        Fasilitas::create($validated);

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', "Fasilitas \"{$validated['name']}\" berhasil ditambahkan.");
    }

    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.form', compact('fasilitas'));
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'address' => 'required|string|max:200',
            'type'    => 'required|string',
            'status'  => 'required|in:open,maintenance',
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Replace photo if a new one was uploaded
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($fasilitas->photo) {
                $oldPath = public_path('images/fasilitas/' . $fasilitas->photo);
                if (file_exists($oldPath)) unlink($oldPath);
            }

            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('images/fasilitas'), $filename);
            $validated['photo'] = $filename;
        } else {
            // Keep existing photo
            unset($validated['photo']);
        }

        $fasilitas->update($validated);

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', "Fasilitas \"{$fasilitas->name}\" berhasil diperbarui.");
    }

    public function destroy(Fasilitas $fasilitas)
    {
        // Delete photo file
        if ($fasilitas->photo) {
            $path = public_path('images/fasilitas/' . $fasilitas->photo);
            if (file_exists($path)) unlink($path);
        }

        $name = $fasilitas->name;
        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', "Fasilitas \"{$name}\" berhasil dihapus.");
    }
}
