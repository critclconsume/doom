@vite(['resources/css/style.css', 'resources/css/admin.css'])

@extends('admin.layout')
@section('title', isset($proyek) ? 'Edit Proyek' : 'Tambah Proyek')

@section('content')

<div class="form-card" 
  <div class="form-head">
    <h2>{{ isset($proyek) ? 'Edit Proyek' : 'Tambah Proyek Baru' }}</h2>
    <p>{{ isset($proyek) ? 'Perbarui informasi proyek pembangunan.' : 'Isi detail proyek pembangunan baru.' }}</p>
  </div>

  @if($errors->any())
  <div class="form-errors">
    <ul>
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ isset($proyek) ? route('admin.proyek.update', $proyek->id) : route('admin.proyek.store') }}"
        method="POST">
    @csrf
    @if(isset($proyek)) @method('PUT') @endif

    {{-- NAMA --}}
    <div class="fgroup">
      <label for="nama">Nama proyek</label>
      <input type="text" id="nama" name="nama"
             placeholder="e.g. Renovasi Stadion Kota"
             value="{{ old('nama', $proyek->nama ?? '') }}">
    </div>

    {{-- DESKRIPSI --}}
    <div class="fgroup">
      <label for="deskripsi">Deskripsi</label>
      <textarea id="deskripsi" name="deskripsi" rows="3"
                placeholder="Deskripsi singkat proyek...">{{ old('deskripsi', $proyek->deskripsi ?? '') }}</textarea>
    </div>

    {{-- LOKASI --}}
    <div class="fgroup">
      <label for="lokasi">Lokasi</label>
      <input type="text" id="lokasi" name="lokasi"
             placeholder="e.g. Jl. Sudirman No. 10"
             value="{{ old('lokasi', $proyek->lokasi ?? '') }}">
    </div>

    {{-- STATUS --}}
    <div class="fgroup">
      <label for="status">Status proyek</label>
      <select id="status" name="status">
        @foreach(['berlangsung' => 'Berlangsung', 'perencanaan' => 'Perencanaan', 'selesai' => 'Selesai'] as $val => $label)
          <option value="{{ $val }}" {{ old('status', $proyek->status ?? '') === $val ? 'selected' : '' }}>
            {{ $label }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- TANGGAL row --}}
    <div class="form-row">
      <div class="fgroup">
        <label for="tanggal_mulai">Tanggal mulai</label>
        <input type="date" id="tanggal_mulai" name="tanggal_mulai"
               value="{{ old('tanggal_mulai', isset($proyek) ? $proyek->tanggal_mulai?->format('Y-m-d') : '') }}">
      </div>
      <div class="fgroup">
        <label for="tanggal_selesai">Tanggal selesai</label>
        <input type="date" id="tanggal_selesai" name="tanggal_selesai"
               value="{{ old('tanggal_selesai', isset($proyek) ? $proyek->tanggal_selesai?->format('Y-m-d') : '') }}">
      </div>
    </div>

    <div style="display:flex; gap:10px; margin-top:8px;">
      <button type="submit" class="form-submit" style="flex:1;">
        {{ isset($proyek) ? 'Simpan Perubahan' : 'Tambah Proyek' }}
      </button>
      <a href="{{ route('admin.proyek.index') }}" class="btn-cancel">Batal</a>
    </div>

  </form>
</div>

@endsection