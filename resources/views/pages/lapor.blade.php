<?php
$success = false;
$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ── Sanitize & validate ──
    $nama    = trim($_POST['nama']    ?? '');
    $telepon = trim($_POST['telepon'] ?? '');
    $lokasi  = trim($_POST['lokasi']  ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($nama === '')      $errors[] = 'Nama wajib diisi.';
    if ($telepon === '')   $errors[] = 'Nomor telepon wajib diisi.';
    if ($lokasi === '')    $errors[] = 'Pilih fasilitas / lokasi.';
    if ($deskripsi === '') $errors[] = 'Deskripsi masalah wajib diisi.';

    // ── Handle photo upload ──
    $foto_path = null;
    if (!empty($_FILES['foto']['name'])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext)) {
            $errors[] = 'Format foto tidak didukung. Gunakan JPG, PNG, atau WEBP.';
        } elseif ($_FILES['foto']['size'] > 5 * 1024 * 1024) {
            $errors[] = 'Ukuran foto maksimal 5 MB.';
        } else {
            $upload_dir = 'uploads/laporan/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            $filename   = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['foto']['name']);
            $foto_path  = $upload_dir . $filename;
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
                $errors[] = 'Gagal mengunggah foto. Coba lagi.';
            }
        }
    }

    if (empty($errors)) {
        // ── TODO: Save to database ──
        // Example (uncomment after DB is set up):
        // $stmt = $pdo->prepare("INSERT INTO laporan (nama, telepon, lokasi, deskripsi, foto, created_at)
        //                        VALUES (?, ?, ?, ?, ?, NOW())");
        // $stmt->execute([$nama, $telepon, $lokasi, $deskripsi, $foto_path]);

        $success = true;
    }
}
?>

@extends('layouts.app')

@section('title', 'Laporkan Masalah')

@section('content')

<div class="lapor-wrap">

  @if (session('success'))
  {{-- SUCCESS STATE --}}
  <div class="success-box">
    <div class="success-mark">&#10003;</div>
    @vite(['resources/css/style.css'])
    <h3>Laporan berhasil dikirim!</h3>
    <p>Terima kasih. Laporan Anda sudah diterima dan akan segera ditindaklanjuti oleh staf dinas terkait.</p>
    <a href="{{ route('beranda') }}" class="btn-primary">Kembali ke beranda</a>
  </div>

  @else
  {{-- FORM --}}
  <div class="form-card">
    <div class="form-head">
      <h2>Laporkan Masalah Fasilitas</h2>
      <p>Laporan Anda akan diteruskan langsung ke dinas terkait. Staf kami akan menindaklanjuti secepatnya.</p>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
    <div class="form-errors">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-row">
        <div class="fgroup">
          <label for="nama">Nama lengkap</label>
          <input type="text" id="nama" name="nama"
                 placeholder="Nama Anda"
                 value="{{ old('nama') }}">
        </div>
        <div class="fgroup">
          <label for="telepon">No. telepon</label>
          <input type="tel" id="telepon" name="telepon"
                 placeholder="08xx-xxxx-xxxx"
                 value="{{ old('telepon') }}">
        </div>
      </div>

      <div class="fgroup">
        <label for="lokasi">Fasilitas / Lokasi</label>
        <select id="lokasi" name="lokasi">
          <option value="">Pilih fasilitas...</option>
          @foreach (['Puskesmas Pusat','Perpustakaan Umum','Stadion Kota','Taman Kota','Terminal Bus','Lainnya'] as $opt)
          <option value="{{ $opt }}" {{ old('lokasi') === $opt ? 'selected' : '' }}>
            {{ $opt }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="fgroup">
        <label for="deskripsi">Deskripsi masalah</label>
        <textarea id="deskripsi" name="deskripsi"
                  placeholder="Ceritakan masalah yang Anda temui secara singkat dan jelas...">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="fgroup">
        <label for="foto">Foto (opsional)</label>
        <label for="foto" class="upload-box">
          <div class="upload-icon">&#128247;</div>
          <span id="upload-label">Klik untuk unggah foto, atau seret ke sini</span>
          <input type="file" id="foto" name="foto"
                 accept=".jpg,.jpeg,.png,.webp"
                 style="display:none;"
                 onchange="updateLabel(this)">
        </label>
      </div>

      <button type="submit" class="form-submit">Kirim Laporan</button>
    </form>
  </div>
  @endif

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
