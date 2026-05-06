<?php
// ── Placeholder data — replace with DB queries later ──
$projects = [
    [
        'name'   => 'Renovasi Stadion Kota',
        'desc'   => 'Peningkatan kapasitas tribun dan fasilitas penonton',
        'status' => 'berlangsung',
    ],
    [
        'name'   => 'Pelebaran Jalan Utama',
        'desc'   => 'Jl. Sudirman — penambahan jalur sepeda dan trotoar',
        'status' => 'berlangsung',
    ],
    [
        'name'   => 'Pembangunan Taman Baru',
        'desc'   => 'Area hijau baru di kawasan Kecamatan Timur',
        'status' => 'perencanaan',
    ],
    [
        'name'   => 'Perbaikan Drainase Kota',
        'desc'   => 'Saluran air di pusat kota — selesai 2024',
        'status' => 'selesai',
    ],
    [
        'name'   => 'Gedung Serbaguna',
        'desc'   => 'Pusat kegiatan warga RT/RW — selesai 2023',
        'status' => 'selesai',
    ],
];

$status_map = [
    'berlangsung' => ['dot' => '#1D9E75', 'badge_class' => 'badge-berlangsung', 'label' => 'Berlangsung'],
    'perencanaan' => ['dot' => '#BA7517', 'badge_class' => 'badge-perencanaan', 'label' => 'Perencanaan'],
    'selesai'     => ['dot' => '#888780', 'badge_class' => 'badge-selesai',     'label' => 'Selesai'],
];
?>

@extends('layouts.app')

@section('title', 'Proyek')

@section('content')


<div class="section">
  <div class="section-header" style="margin-top: 8px;">
    <div class="section-title">Proyek pembangunan</div>
    @vite(['resources/css/style.css'])
  </div>

  <div class="proyek-list">
    @foreach ($projects as $p)
    <div class="proyek-item">
      <div class="proyek-dot"
           style="background: {{ $statusMap[$p['status']]['dot'] }};"></div>
      <div class="proyek-info">
        <h4>{{ $p['name'] }}</h4>
        <p>{{ $p['desc'] }}</p>
      </div>
      <span class="proyek-badge {{ $statusMap[$p['status']]['class'] }}">
        {{ $statusMap[$p['status']]['label'] }}
      </span>
    </div>
    @endforeach
  </div>

  <div class="proyek-legend">
    <div class="legend-item">
      <span class="legend-dot" style="background:#1D9E75;"></span>Berlangsung
    </div>
    <div class="legend-item">
      <span class="legend-dot" style="background:#BA7517;"></span>Perencanaan
    </div>
    <div class="legend-item">
      <span class="legend-dot" style="background:#888780;"></span>Selesai
    </div>
  </div>
</div>

@endsection
