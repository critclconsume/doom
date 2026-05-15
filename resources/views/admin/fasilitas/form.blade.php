@vite(['resources/css/style.css', 'resources/css/admin.css'])

@extends('admin.layout')
@section('title', $fasilitas ? 'Edit Fasilitas' : 'Tambah Fasilitas Baru')

@section('content')

<div class="admin-form-container">
    <div class="admin-form-header">
        <h1>{{ $fasilitas ? 'Edit Fasilitas' : 'Tambah Fasilitas Baru' }}</h1>
        <p>{{ $fasilitas ? 'Perbarui informasi fasilitas' : 'Masukkan data fasilitas publik' }}</p>
    </div>

    <form action="{{ $action }}" method="{{ $method }}" enctype="multipart/form-data" class="admin-form">
        @csrf
        @if($method === 'PUT')
            @method('PUT')
        @endif

        <div class="form-grid">

            <!-- Name -->
            <div class="form-group">
                <label for="name">Nama Fasilitas</label>
                <input type="text" name="name" id="name" 
                       value="{{ $fasilitas?->name }}" 
                       required class="form-input">
            </div>

            <!-- Type -->
            <div class="form-group">
                <label for="type">Jenis Fasilitas</label>
                <input type="text" name="type" id="type" 
                       value="{{ $fasilitas?->type }}" 
                       placeholder="Contoh: Taman, Lapangan, Gedung, dll" required class="form-input">
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" required class="form-input">
                    <option value="open" {{ ($fasilitas?->status ?? 'open') === 'open' ? 'selected' : '' }}>Buka</option>
                    <option value="maintenance" {{ $fasilitas?->status === 'maintenance' ? 'selected' : '' }}>Renovasi / Maintenance</option>
                </select>
            </div>

            <!-- Address -->
            <div class="form-group full-width">
                <label for="address">Alamat / Lokasi</label>
                <textarea name="address" id="address" rows="3" 
                          required class="form-input">{{ $fasilitas?->address }}</textarea>
            </div>

            <!-- Photo -->
            <div class="form-group full-width">
                <label for="photo">Foto Fasilitas 
                    <span class="label-small">(JPG, PNG, WEBP, GIF - max 10MB)</span>
                </label>
                
                @if($fasilitas?->photo)
                <div class="current-photo">
                    <img src="{{ asset('images/fasilitas/' . $fasilitas->photo) }}" 
                         alt="Current Photo" class="preview-image">
                    <p class="small">Foto saat ini</p>
                </div>
                @endif

                <input type="file" name="photo" id="photo" 
                       accept="image/jpeg,image/png,image/webp,image/gif" 
                       class="form-input file-input">
                <small class="help-text">Biarkan kosong jika tidak ingin mengubah foto</small>
            </div>

        </div>

        <!-- Buttons -->
        <div class="form-actions">
            <a href="{{ route('admin.fasilitas.index') }}" class="btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                {{ $fasilitas ? 'Simpan Perubahan' : 'Tambah Fasilitas' }}
            </button>
        </div>
    </form>
</div>

@endsection