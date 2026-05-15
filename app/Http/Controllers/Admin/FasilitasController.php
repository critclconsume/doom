<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::latest()->paginate(10);
        return view('admin.fasilitas.fain', compact('fasilitas'));
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
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'type'    => 'required|string',
            'status'  => 'required|in:open,maintenance',
            'photo'   => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:15368', // 15MB
        ]);

        $data = $request->only(['name', 'address', 'type', 'status']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                        . '.' . $file->getClientOriginalExtension();

            $path = public_path('images/fasilitas');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $file->move($path, $filename);
            $data['photo'] = $filename;
        }

        Fasilitas::create($data);

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil ditambahkan');
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
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'type'    => 'required|string',
            'status'  => 'required|in:open,maintenance',
            'photo'   => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:15368', // 15MB
        ]);

        $data = $request->only(['name', 'address', 'type', 'status']);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($fasilitas->photo && file_exists(public_path('images/fasilitas/' . $fasilitas->photo))) {
                unlink(public_path('images/fasilitas/' . $fasilitas->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                        . '.' . $file->getClientOriginalExtension();

            $path = public_path('images/fasilitas');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $file->move($path, $filename);
            $data['photo'] = $filename;
        }

        $fasilitas->update($data);

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil diperbarui');
    }

    public function destroy(Fasilitas $fasilitas)
    {
        if ($fasilitas->photo) {
            $oldPath = public_path('images/fasilitas/' . $fasilitas->photo);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil dihapus.');
    }
}