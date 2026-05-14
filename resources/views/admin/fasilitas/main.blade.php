@extends('layouts.app')
@section('title', 'Daftar Fasilitas')

@section('content')
<div class="admin-header">
    <h1>Daftar Fasilitas</h1>
    <a href="{{ route('admin.fasilitas.create') }}" class="btn-primary">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Fasilitas Baru
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Fasilitas</th>
                    <th>Alamat</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fasilitas as $f)
                <tr>
                    <td>
                        @if($f->photo && file_exists(public_path('images/fasilitas/' . $f->photo)))
                            <img src="{{ asset('images/fasilitas/' . $f->photo) }}" 
                                 alt="{{ $f->name }}" 
                                 class="table-photo">
                        @else
                            <div class="table-photo-placeholder">No Photo</div>
                        @endif
                    </td>
                    <td><strong>{{ $f->name }}</strong></td>
                    <td>{{ $f->address }}</td>
                    <td>{{ $f->type }}</td>
                    <td>
                        <span class="badge {{ $f->status === 'open' ? 'badge-open' : 'badge-maintenance' }}">
                            {{ $f->status === 'open' ? 'Buka' : 'Renovasi/Maintenance' }}
                        </span>
                    </td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.fasilitas.edit', $f) }}" class="btn-edit">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 5.732z" />
                            </svg>
                            Edit
                        </a>
                        
                        <form action="{{ route('admin.fasilitas.destroy', $f) }}" method="POST" style="display:inline;" 
                              onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.595 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.595-1.858L5 7m5 4v6m4-6v6m1-10V9a1 1 0 00-1 1v1M12 4v6m2-6v6" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:30px;">
                        Belum ada data fasilitas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection