@extends('admin.layout')
@section('title', 'Laporan Masalah')

@section('content')

{{-- FILTER TABS --}}
<div class="filter-tabs">
  @foreach(['semua' => 'Semua', 'menunggu' => 'Menunggu', 'diterima' => 'Diterima', 'selesai' => 'Selesai'] as $val => $label)
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
        <th>Foto</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($laporan as $l)
      <tr>
        <td>{{ $l->id }}</td>
        <td>{{ $l->nama }}</td>
        <td>{{ $l->telepon }}</td>
        <td>{{ $l->lokasi }}</td>
        <td class="td-truncate">{{ Str::limit($l->deskripsi, 70) }}</td>
        <td>
          @if($l->foto)
            <a href="{{ Storage::url($l->foto) }}" target="_blank" class="photo-thumb-link">
              <img src="{{ Storage::url($l->foto) }}" alt="Foto laporan" class="photo-thumb">
            </a>
          @else
            <span class="text-muted">—</span>
          @endif
        </td>
        <td><span class="status-badge status-{{ $l->status }}">{{ ucfirst($l->status) }}</span></td>
        <td>{{ $l->created_at->format('d M Y') }}</td>
        <td>
          <div class="action-btns">
            {{-- Laporan Diterima --}}
            @if($l->status === 'menunggu')
            <form action="{{ route('admin.laporan.updateStatus', $l->id) }}" method="POST">
              @csrf @method('PATCH')
              <input type="hidden" name="status" value="diterima">
              <button type="submit" class="btn-action btn-diterima">Diterima</button>
            </form>
            @endif

            {{-- Laporan Selesai --}}
            @if(in_array($l->status, ['menunggu','diterima']))
            <form action="{{ route('admin.laporan.updateStatus', $l->id) }}" method="POST">
              @csrf @method('PATCH')
              <input type="hidden" name="status" value="selesai">
              <button type="submit" class="btn-action btn-selesai">Selesai</button>
            </form>
            @endif
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
