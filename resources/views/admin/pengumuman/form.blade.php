@extends('admin.layout')
@section('title', isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')

<div class="form-card" style="max-width: 600px;">
  <div class="form-head">
    <h2>{{ isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman Baru' }}</h2>
    <p>Pengumuman yang dipublikasi akan tampil di halaman Beranda untuk semua pengguna.</p>
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

    {{-- TANGGAL --}}
    <div class="fgroup">
      <label for="tanggal">Tanggal</label>
      <input type="date" id="tanggal" name="tanggal"
             value="{{ old('tanggal', isset($pengumuman) ? $pengumuman->tanggal->format('Y-m-d') : now()->format('Y-m-d')) }}">
    </div>

    {{-- ISI --}}
    <div class="fgroup">
      <label for="isi">Isi pengumuman</label>
      <textarea id="isi" name="isi" rows="5"
                placeholder="Tulis isi pengumuman di sini...">{{ old('isi', $pengumuman->isi ?? '') }}</textarea>
    </div>

    {{-- PUBLISHED TOGGLE --}}
    <div class="fgroup publish-toggle">
      <label class="toggle-label">
        <input type="checkbox" name="is_published"
               {{ old('is_published', $pengumuman->is_published ?? true) ? 'checked' : '' }}>
        <span class="toggle-track">
          <span class="toggle-thumb"></span>
        </span>
        <span class="toggle-text">Publikasikan ke halaman Beranda</span>
      </label>
      <div class="fgroup-hint">Jika tidak dicentang, pengumuman tersimpan sebagai draft dan tidak tampil ke publik.</div>
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
