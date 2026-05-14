<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::latest()->paginate(10);
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('admin.fasilitas.form', [
            'fasilitas' => null,
            'action'    => route('admin.fasilitas.store'),
            'method'    => 'POST'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'type'    => 'required|string',
            'status'  => 'required|in:open,maintenance',
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('images/fasilitas'), $filename);
            $validated['photo'] = $filename;
        }

        Fasilitas::create($validated);

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.form', [
            'fasilitas' => $fasilitas,
            'action'    => route('admin.fasilitas.update', $fasilitas),
            'method'    => 'PUT'
        ]);
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'type'    => 'required|string',
            'status'  => 'required|in:open,maintenance',
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($fasilitas->photo) {
                $oldPath = public_path('images/fasilitas/' . $fasilitas->photo);
                if (file_exists($oldPath)) unlink($oldPath);
            }

            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('images/fasilitas'), $filename);
            $validated['photo'] = $filename;
        }

        $fasilitas->update($validated);

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Fasilitas $fasilitas)
    {
        if ($fasilitas->photo) {
            $oldPath = public_path('images/fasilitas/' . $fasilitas->photo);
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil dihapus.');
    }
}