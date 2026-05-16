@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')

{{-- ══════════════ LAPORAN ══════════════ --}}
<div class="dash-category-block">
  <div class="dash-category-header">
    <div class="dash-category-title">Laporan Masalah</div>
    <a href="{{ route('admin.laporan.index') }}" class="admin-section-link">Lihat Semua →</a>
  </div>

  <div class="dash-stats-row">
    <div class="dash-stat-card">
      <div class="dash-stat-num dash-stat-warn">{{ $laporanMenunggu }}</div>
      <div class="dash-stat-label">Menunggu</div>
    </div>
    <div class="dash-stat-card">
      <div class="dash-stat-num" style="color:#3730A3;">{{ $laporanDiterima }}</div>
      <div class="dash-stat-label">Diterima</div>
    </div>
    <div class="dash-stat-card">
      <div class="dash-stat-num dash-stat-green">{{ $laporanSelesai }}</div>
      <div class="dash-stat-label">Selesai</div>
    </div>
    <div class="dash-stat-card">
      <div class="dash-stat-num" style="color:#e11d48;">{{ $laporanDitolak }}</div>
      <div class="dash-stat-label">Ditolak</div>
    </div>
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
          <td>
            <a href="{{ route('admin.laporan.show', $l) }}" class="dash-row-link">{{ $l->nama }}</a>
          </td>
          <td>{{ $l->lokasi }}</td>
          <td class="td-truncate">{{ Str::limit($l->deskripsi, 60) }}</td>
          <td><span class="status-badge status-{{ $l->status }}">{{ ucfirst($l->status) }}</span></td>
          <td>{{ $l->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>

{{-- ══════════════ FASILITAS ══════════════ --}}
<div class="dash-category-block">
  <div class="dash-category-header">
    <div class="dash-category-title">Fasilitas Publik</div>
    <a href="{{ route('admin.fasilitas.index') }}" class="admin-section-link">Lihat Semua →</a>
  </div>

  <div class="dash-stats-row">
    <div class="dash-stat-card">
      <div class="dash-stat-num">{{ $totalFasilitas }}</div>
      <div class="dash-stat-label">Total Fasilitas</div>
    </div>
    <div class="dash-stat-card">
      <div class="dash-stat-num dash-stat-green">{{ $fasilitasBuka }}</div>
      <div class="dash-stat-label">Buka</div>
    </div>
    <div class="dash-stat-card">
      <div class="dash-stat-num dash-stat-warn">{{ $fasilitasRenovasi }}</div>
      <div class="dash-stat-label">Renovasi</div>
    </div>
  </div>

  @if($recentFasilitas->isEmpty())
    <div class="empty-state">Belum ada fasilitas.</div>
  @else
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Jenis</th>
          <th>Status</th>
          <th>Ditambahkan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentFasilitas as $f)
        <tr>
          <td style="font-weight:500;">{{ $f->name }}</td>
          <td class="td-truncate">{{ $f->address }}</td>
          <td>{{ $f->type }}</td>
          <td>
            <span class="tag {{ $f->status === 'open' ? 'tag-open' : 'tag-maint' }}">
              {{ $f->status === 'open' ? 'Buka' : 'Renovasi' }}
            </span>
          </td>
          <td>{{ $f->created_at?->format('d M Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>

{{-- ══════════════ PROYEK ══════════════ --}}
<div class="dash-category-block">
  <div class="dash-category-header">
    <div class="dash-category-title">Proyek Pembangunan</div>
    <a href="{{ route('admin.proyek.index') }}" class="admin-section-link">Lihat Semua →</a>
  </div>

  <div class="dash-stats-row">
    <div class="dash-stat-card">
      <div class="dash-stat-num dash-stat-green">{{ $proyekBerlangsung }}</div>
      <div class="dash-stat-label">Berlangsung</div>
    </div>
    <div class="dash-stat-card">
      <div class="dash-stat-num dash-stat-warn">{{ $proyekPerencanaan }}</div>
      <div class="dash-stat-label">Perencanaan</div>
    </div>
    <div class="dash-stat-card">
      <div class="dash-stat-num" style="color:var(--gray-700);">{{ $proyekSelesai }}</div>
      <div class="dash-stat-label">Selesai</div>
    </div>
  </div>

  @if($recentProyek->isEmpty())
    <div class="empty-state">Belum ada proyek.</div>
  @else
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Lokasi</th>
          <th>Status</th>
          <th>Mulai</th>
          <th>Selesai</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentProyek as $p)
        @php
          $badge = ['berlangsung'=>'status-selesai','perencanaan'=>'status-menunggu','selesai'=>'status-diterima'][$p->status] ?? '';
          $label = ['berlangsung'=>'Berlangsung','perencanaan'=>'Perencanaan','selesai'=>'Selesai'][$p->status] ?? $p->status;
        @endphp
        <tr>
          <td style="font-weight:500;">{{ $p->nama }}</td>
          <td>{{ $p->lokasi }}</td>
          <td><span class="status-badge {{ $badge }}">{{ $label }}</span></td>
          <td>{{ $p->tanggal_mulai?->format('d M Y') ?? '—' }}</td>
          <td>{{ $p->tanggal_selesai?->format('d M Y') ?? '—' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>

{{-- ══════════════ PENGUMUMAN ══════════════ --}}
<div class="dash-category-block">
  <div class="dash-category-header">
    <div class="dash-category-title">Pengumuman</div>
    <a href="{{ route('admin.pengumuman.index') }}" class="admin-section-link">Lihat Semua →</a>
  </div>

  <div class="dash-stats-row">
    <div class="dash-stat-card">
      <div class="dash-stat-num dash-stat-green">{{ $pengumumanPublished }}</div>
      <div class="dash-stat-label">Dipublikasi</div>
    </div>
    <div class="dash-stat-card">
      <div class="dash-stat-num" style="color:var(--gray-700);">{{ $pengumumanDraft }}</div>
      <div class="dash-stat-label">Draft</div>
    </div>
  </div>

  @if($recentPengumuman->isEmpty())
    <div class="empty-state">Belum ada pengumuman.</div>
  @else
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Judul</th>
          <th>Isi</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentPengumuman as $p)
        <tr>
          <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</td>
          <td style="font-weight:500;">{{ $p->judul }}</td>
          <td class="td-truncate">{{ Str::limit($p->isi, 70) }}</td>
          <td>
            @if($p->is_published)
              <span class="status-badge status-selesai">Dipublikasi</span>
            @else
              <span class="status-badge status-menunggu">Draft</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>

@endsection