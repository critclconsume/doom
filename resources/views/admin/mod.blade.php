@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')

{{-- ── STATS ROW ── --}}
<!-- Combined Laporan Detail Card (keep previous design) -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Laporan Masalah</h3>
        <a href="{{ route('admin.laporan.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">
            Lihat Semua →
        </a>
    </div>

    <!-- Status Breakdown -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white border border-yellow-200 rounded-2xl p-5 text-center">
            <div class="text-3xl font-semibold text-yellow-600">{{ $laporanMenunggu }}</div>
            <div class="text-sm text-gray-600">Menunggu</div>
        </div>
        <div class="bg-white border border-blue-200 rounded-2xl p-5 text-center">
            <div class="text-3xl font-semibold text-blue-600">{{ $laporanDiterima }}</div>
            <div class="text-sm text-gray-600">Diterima</div>
        </div>
        <div class="bg-white border border-green-200 rounded-2xl p-5 text-center">
            <div class="text-3xl font-semibold text-green-600">{{ $laporanSelesai }}</div>
            <div class="text-sm text-gray-600">Selesai</div>
        </div>
        <div class="bg-white border border-rose-200 rounded-2xl p-5 text-center">
            <div class="text-3xl font-semibold text-rose-600">{{ $laporanDitolak }}</div>
            <div class="text-sm text-gray-600">Ditolak</div>
        </div>
    </div>
</div>

{{-- ── RECENT LAPORAN ── --}}
<div class="admin-section">
  <div class="admin-section-header">
    <div class="admin-section-title">Laporan terbaru</div>
    <a href="{{ route('admin.laporan.index') }}" class="admin-section-link">Lihat semua →</a>
  </div>

  @if($recentLaporan->isEmpty())
    <div class="empty-state">Belum ada laporan masuk.</div>
  @else
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Lokasi</th>
          <th>Deskripsi</th>
          <th>Status</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentLaporan as $l)
        <tr>
          <td>{{ $l->nama }}</td>
          <td>{{ $l->lokasi }}</td>
          <td class="td-truncate">{{ Str::limit($l->deskripsi, 60) }}</td>
          <td>
            <span class="status-badge status-{{ $l->status }}">
              {{ ucfirst($l->status) }}
            </span>
          </td>
          <td>{{ $l->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>

@endsection
