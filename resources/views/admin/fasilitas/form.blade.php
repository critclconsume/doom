@vite(['resources/css/style.css', 'resources/css/admin.css'])

@extends('admin.layout')
@section('title', $fasilitas ? 'Edit Fasilitas' : 'Tambah Fasilitas Baru')

@section('content')
    
<div class="admin-form-container">
    <div class="admin-form-header">
        <h1>{{ $fasilitas ? 'Edit Fasilitas' : 'Tambah Fasilitas Baru' }}</h1>
        <p>{{ $fasilitas ? 'Perbarui informasi fasilitas' : 'Masukkan data fasilitas publik' }}</p>
    </div>

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @if($method === 'PUT')
            @method('PUT')
        @endif

        <div class="form-grid">

            {{-- NAME --}}
            <div class="form-group">
                <label for="name">Nama Fasilitas</label>
                <input type="text" name="name" id="name"
                       value="{{ $fasilitas?->name }}"
                       required class="form-input">
            </div>

            {{-- TYPE --}}
            <div class="form-group">
                <label for="type">Jenis Fasilitas</label>
                <input type="text" name="type" id="type"
                       value="{{ $fasilitas?->type }}"
                       placeholder="Contoh: Taman, Lapangan, Gedung, dll"
                       required class="form-input">
            </div>

            {{-- STATUS --}}
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" required class="form-input">
                    <option value="open"        {{ ($fasilitas?->status ?? 'open') === 'open'        ? 'selected' : '' }}>Buka</option>
                    <option value="maintenance" {{ $fasilitas?->status === 'maintenance'             ? 'selected' : '' }}>Renovasi / Maintenance</option>
                </select>
            </div>

            {{-- ADDRESS --}}
            <div class="form-group full-width">
                <label for="address">Alamat / Lokasi</label>
                <textarea name="address" id="address" rows="3"
                          required class="form-input">{{ $fasilitas?->address }}</textarea>
            </div>

            {{-- MAIN PHOTO --}}
            <div class="form-group full-width">
                <label for="photo">Foto Utama
                    <span class="label-small">(JPG, PNG, WEBP, GIF — maks 10MB)</span>
                </label>

                @if($fasilitas?->photo)
                <div class="current-photo" style="margin-bottom:10px;">
                    <img src="{{ asset('images/fasilitas/' . $fasilitas->photo) }}"
                         alt="Foto saat ini" class="preview-image">
                </div>
                @endif

                <input type="file" name="photo" id="photo"
                       accept="image/jpeg,image/png,image/webp,image/gif"
                       class="form-input file-input">
                <small class="help-text">Biarkan kosong jika tidak ingin mengubah foto utama</small>
            </div>

            {{-- ADDITIONAL PHOTOS --}}
            <div class="form-group full-width">
                <label for="photos_extra">Foto Tambahan (Galeri)
                    <span class="label-small">(Bisa pilih lebih dari 1 foto)</span>
                </label>

                @if(isset($fasilitas) && $fasilitas->photos->count() > 0)
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:10px;">
                    @foreach($fasilitas->photos as $p)
                    <img src="{{ asset('images/fasilitas/' . $p->photo) }}"
                         style="width:72px; height:72px; object-fit:cover; border-radius:8px; border:0.5px solid var(--border);">
                    @endforeach
                </div>
                <p class="small" style="margin-bottom:8px;">Foto tambahan yang sudah ada</p>
                @endif

                <input type="file" name="photos_extra[]" id="photos_extra"
                       accept="image/jpeg,image/png,image/webp,image/gif"
                       multiple
                       class="form-input file-input">
                <small class="help-text">Upload beberapa foto sekaligus untuk galeri fasilitas</small>
            </div>

        </div>

        {{-- BUTTONS --}}
        <div class="form-actions">
            <a href="{{ route('admin.fasilitas.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
                {{ $fasilitas ? 'Simpan Perubahan' : 'Tambah Fasilitas' }}
            </button>
        </div>

    </form>
</div>

@endsection