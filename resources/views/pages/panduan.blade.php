<?php
$warga_steps = [
    [
        'title' => 'Lihat daftar fasilitas',
        'body'  => 'Buka halaman Beranda untuk melihat seluruh fasilitas publik yang tersedia, beserta status operasional dan lokasi masing-masing.',
    ],
    [
        'title' => 'Periksa proyek pembangunan',
        'body'  => 'Klik menu Proyek untuk melihat daftar proyek yang sedang berjalan, dalam perencanaan, atau telah selesai di kota Anda.',
    ],
    [
        'title' => 'Laporkan masalah fasilitas',
        'body'  => 'Temukan masalah? Klik tombol "Laporkan Masalah" di pojok kanan atas, isi formulir dengan nama, nomor telepon, lokasi, deskripsi masalah, dan foto jika ada, lalu kirim.',
    ],
    [
        'title' => 'Laporan diteruskan ke dinas',
        'body'  => 'Setelah dikirim, laporan Anda secara otomatis diteruskan ke dinas terkait. Petugas akan menerima notifikasi dan menindaklanjuti laporan.',
    ],
];

$admin_steps = [
    [
        'title' => 'Login ke WordPress Admin',
        'body'  => 'Akses halaman admin melalui <code>/wp-admin</code> menggunakan akun yang telah diberikan oleh administrator sistem.',
    ],
    [
        'title' => 'Perbarui konten website',
        'body'  => 'Edit halaman fasilitas, tambahkan foto, perbarui status proyek, atau tambahkan pengumuman baru sesuai kebutuhan.',
    ],
    [
        'title' => 'Publikasikan perubahan',
        'body'  => 'Klik tombol Publish atau Update di WordPress untuk menyimpan dan menayangkan perubahan ke publik secara langsung.',
    ],
];
?>


@extends('home')

@section('title', 'Buku Panduan')

@section('content')

<div class="panduan-wrap">
  <div class="panduan-intro">
    <div class="section-title" style="font-size:17px;">Buku Panduan Penggunaan</div>
    @vite(['resources/css/style.css'])
    <p>Panduan lengkap cara menggunakan website FasilitasKota untuk warga dan petugas dinas.</p>
  </div>

  {{-- FOR WARGA --}}
  <div class="panduan-group-label">Untuk warga</div>

  @foreach ($wargaSteps as $i => $step)
  <div class="panduan-step">
    <div class="step-num">{{ $i + 1 }}</div>
    <div class="step-body">
      <h4>{{ $step['title'] }}</h4>
      <p>{!! $step['body'] !!}</p>
    </div>
  </div>
  @endforeach

  {{-- FOR ADMIN --}}
  <div class="panduan-group-label" style="margin-top: 28px;">Untuk petugas / admin</div>

  @foreach ($adminSteps as $i => $step)
  <div class="panduan-step">
    <div class="step-num">{{ $i + 1 }}</div>
    <div class="step-body">
      <h4>{{ $step['title'] }}</h4>
      <p>{!! $step['body'] !!}</p>
    </div>
  </div>
  @endforeach

  <div class="panduan-note">
    <strong>Catatan:</strong> Jika ada kendala teknis saat mengakses admin atau mengirim laporan,
    hubungi tim IT dinas melalui email atau nomor telepon yang tertera di halaman Kontak.
  </div>
</div>

@endsection
