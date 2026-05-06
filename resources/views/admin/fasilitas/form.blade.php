@extends('admin.layout')
@section('title', isset($fasilitas) ? 'Edit Fasilitas' : 'Tambah Fasilitas')

@section('content')

<div class="form-card" style="max-width: 560px;">
  <div class="form-head">
    <h2>{{ isset($fasilitas) ? 'Edit Fasilitas' : 'Tambah Fasilitas Baru' }}</h2>
    <p>{{ isset($fasilitas) ? 'Perbarui informasi fasilitas di bawah ini.' : 'Isi informasi fasilitas yang akan ditampilkan ke publik.' }}</p>
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

  <form action="{{ isset($fasilitas) ? route('admin.fasilitas.update', $fasilitas->id) : route('admin.fasilitas.store') }}"
        method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($fasilitas)) @method('PUT') @endif

    {{-- NAME --}}
    <div class="fgroup">
      <label for="name">Nama fasilitas</label>
      <input type="text" id="name" name="name"
             placeholder="e.g. Puskesmas Pusat"
             value="{{ old('name', $fasilitas->name ?? '') }}">
    </div>

    {{-- ADDRESS --}}
    <div class="fgroup">
      <label for="address">Alamat</label>
      <input type="text" id="address" name="address"
             placeholder="e.g. Jl. Sudirman No. 12"
             value="{{ old('address', $fasilitas->address ?? '') }}">
    </div>

    {{-- TYPE + STATUS row --}}
    <div class="form-row">
      <div class="fgroup">
        <label for="type">Tipe fasilitas</label>
        <select id="type" name="type">
          @foreach(['Kesehatan','Pendidikan','Olahraga','Ruang Hijau','Transportasi','Lainnya'] as $t)
          <option value="{{ $t }}"
            {{ old('type', $fasilitas->type ?? '') === $t ? 'selected' : '' }}>
            {{ $t }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="fgroup">
        <label for="status">Status</label>
        <select id="status" name="status">
          <option value="open"        {{ old('status', $fasilitas->status ?? '') === 'open'        ? 'selected' : '' }}>Buka</option>
          <option value="maintenance" {{ old('status', $fasilitas->status ?? '') === 'maintenance' ? 'selected' : '' }}>Renovasi</option>
        </select>
      </div>
    </div>

    {{-- PHOTO --}}
    <div class="fgroup">
      <label for="photo">Foto fasilitas</label>

      {{-- Show current photo if editing --}}
      @if(isset($fasilitas) && $fasilitas->photo && file_exists(public_path('images/fasilitas/' . $fasilitas->photo)))
      <div class="current-photo-wrap">
        <img src="{{ asset('images/fasilitas/' . $fasilitas->photo) }}"
             alt="{{ $fasilitas->name }}" class="current-photo">
        <span class="current-photo-label">Foto saat ini</span>
      </div>
      @endif

      <label for="photo" class="upload-box">
        <div class="upload-icon">&#128247;</div>
        <span id="upload-label">
          {{ isset($fasilitas) && $fasilitas->photo ? 'Klik untuk ganti foto' : 'Klik untuk unggah foto' }}
        </span>
        <input type="file" id="photo" name="photo"
               accept=".jpg,.jpeg,.png,.webp"
               style="display:none;"
               onchange="updateLabel(this)">
      </label>
      <div class="fgroup-hint">Format: JPG, PNG, WEBP. Maks 5 MB.</div>
    </div>

    <div style="display:flex; gap:10px; margin-top: 8px;">
      <button type="submit" class="form-submit" style="flex:1;">
        {{ isset($fasilitas) ? 'Simpan Perubahan' : 'Tambah Fasilitas' }}
      </button>
      <a href="{{ route('admin.fasilitas.index') }}" class="btn-cancel">Batal</a>
    </div>

  </form>
</div>

<script>
function updateLabel(input) {
  const label = document.getElementById('upload-label');
  if (input.files && input.files[0]) {
    label.textContent = input.files[0].name;
  }
}
</script>

@endsection
