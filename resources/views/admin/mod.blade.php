@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')

{{-- ── STATS ROW ── --}}
<div class="dash-stats">

  <div class="dash-stat-card">
    <div class="dash-stat-num">{{ $totalFasilitas }}</div>
    <div class="dash-stat-label">Total Fasilitas</div>
    <div class="dash-stat-sub">{{ $fasilitasBuka }} buka &middot; {{ $fasilitasRenovasi }} renovasi</div>
  </div>

  <div class="dash-stat-card">
    <div class="dash-stat-num">{{ $totalLaporan }}</div>
    <div class="dash-stat-label">Total Laporan</div>
    <div class="dash-stat-sub">{{ $laporanDiterima }} diterima</div>
  </div>

  <div class="dash-stat-card">
    <div class="dash-stat-num dash-stat-warn">{{ $laporanMenunggu }}</div>
    <div class="dash-stat-label">Laporan Menunggu</div>
    <div class="dash-stat-sub">Perlu ditindaklanjuti</div>
  </div>

  <div class="dash-stat-card">
    <div class="dash-stat-num dash-stat-green">{{ $laporanSelesai }}</div>
    <div class="dash-stat-label">Laporan Selesai</div>
    <div class="dash-stat-sub">Sudah diselesaikan</div>
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
