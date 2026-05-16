@extends('admin.layout')

@section('title', 'Laporan Masalah')

@section('content')

{{-- FILTER TABS --}}
<div class="filter-tabs">
  @foreach(['semua' => 'Semua', 'menunggu' => 'Menunggu', 'diterima' => 'Diterima', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $val => $label)
  <a href="{{ route('admin.laporan.index', ['status' => $val]) }}"
     class="filter-tab {{ request('status', 'semua') === $val ? 'active' : '' }}">
    {{ $label }}
    @if($val !== 'semua')
      <span class="filter-count">{{ $counts[$val] ?? 0 }}</span>
    @endif
  </a>
  @endforeach
</div>

@if($laporan->isEmpty())
  <div class="empty-state">Tidak ada laporan untuk filter ini.</div>
@else

<div class="admin-table-wrap">
  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Lokasi</th>
        <th>Deskripsi</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($laporan as $l)
      <tr>
        <td>
          <a href="{{ route('admin.laporan.show', $l) }}" 
             class="font-medium hover:underline text-teal-700">
            #{{ $l->id }}
          </a>
        </td>
        <td>{{ $l->nama }}</td>
        <td>{{ $l->telepon }}</td>
        <td class="max-w-xs">{{ Str::limit($l->lokasi, 50) }}</td>
        <td class="td-truncate">{{ Str::limit($l->deskripsi, 70) }}</td>
        <td><span class="status-badge status-{{ $l->status }}">{{ ucfirst($l->status) }}</span></td>
        <td>{{ $l->created_at->format('d M Y') }}</td>
        <td>
          <div class="action-btns flex flex-col gap-2">
            <a href="{{ route('admin.laporan.show', $l) }}" 
               class="btn-action btn-detail">
              Lihat Detail
            </a>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{-- PAGINATION --}}
<div class="pagination-wrap">
  {{ $laporan->withQueryString()->links() }}
</div>

@endif

@endsection