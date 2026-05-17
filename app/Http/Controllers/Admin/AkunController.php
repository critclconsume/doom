<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $akun = User::latest()->get();
        return view('admin.akun.akain', compact('akun'));
    }

    public function create()
    {
        return view('admin.akun.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.akun.index')
                         ->with('success', "Akun admin \"{$request->name}\" berhasil dibuat.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.akun.index')
                             ->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.akun.index')
                         ->with('success', "Akun \"{$name}\" berhasil dihapus.");
    }

        public function passwordForm()
{
    return view('admin.akun.password');
}

public function passwordUpdate(Request $request)
{
    $request->validate([
        'current_password' => 'required|current_password',
        'password'         => 'required|string|min:8|confirmed',
    ], [
        'current_password.required'    => 'Password saat ini wajib diisi.',
        'current_password.current_password' => 'Password saat ini tidak sesuai.',
        'password.required'            => 'Password baru wajib diisi.',
        'password.min'                 => 'Password minimal 8 karakter.',
        'password.confirmed'           => 'Konfirmasi password tidak cocok.',
    ]);

    $request->user()->update([
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.akun.password')
                     ->with('success', 'Password berhasil diperbarui.');
}
}

    