@vite(['resources/css/style.css', 'resources/css/admin.css'])

@extends('admin.layout')
@section('title', isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')

<div class="form-card">
  <div class="form-head">
    <h2>{{ isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman Baru' }}</h2>
    <p>{{ isset($pengumuman) ? 'Perbarui informasi pengumuman di bawah ini.' : 'Pengumuman yang dipublikasi akan tampil di halaman Beranda.' }}</p>
  </div>

  @if($errors->any())
  <div class="form-errors">
    <ul>
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ isset($pengumuman) ? route('admin.pengumuman.update', $pengumuman->id) : route('admin.pengumuman.store') }}"
        method="POST">
    @csrf
    @if(isset($pengumuman)) @method('PUT') @endif

    {{-- JUDUL --}}
    <div class="fgroup">
      <label for="judul">Judul pengumuman</label>
      <input type="text" id="judul" name="judul"
             placeholder="e.g. Renovasi Stadion Kota dimulai"
             value="{{ old('judul', $pengumuman->judul ?? '') }}">
    </div>

    {{-- TANGGAL + STATUS row --}}
    <div class="form-row">
      <div class="fgroup">
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal"
               value="{{ old('tanggal', isset($pengumuman) ? $pengumuman->tanggal->format('Y-m-d') : now()->format('Y-m-d')) }}">
      </div>

      <div class="fgroup">
        <label>Status publikasi</label>
        <label class="toggle-label" style="margin-top: 9px;">
          <input type="checkbox" name="is_published"
                 {{ old('is_published', $pengumuman->is_published ?? true) ? 'checked' : '' }}>
          <span class="toggle-track">
            <span class="toggle-thumb"></span>
          </span>
          <span class="toggle-text">Dipublikasi</span>
        </label>
      </div>
    </div>

    {{-- ISI --}}
    <div class="fgroup">
      <label for="isi">Isi pengumuman</label>
      <textarea id="isi" name="isi" rows="6"
                placeholder="Tulis isi pengumuman di sini...">{{ old('isi', $pengumuman->isi ?? '') }}</textarea>
    </div>

    <div style="display:flex; gap:10px; margin-top: 8px;">
      <button type="submit" class="form-submit" style="flex:1;">
        {{ isset($pengumuman) ? 'Simpan Perubahan' : 'Tambah Pengumuman' }}
      </button>
      <a href="{{ route('admin.pengumuman.index') }}" class="btn-cancel">Batal</a>
    </div>

  </form>
</div>

@endsection