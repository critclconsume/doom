@extends('admin.layout')
@section('title', 'Proyek Pembangunan')

@section('content')

<div class="admin-section-header" style="margin-bottom:18px; display:flex; align-items:center; justify-content:space-between;">
  <div class="admin-section-title">Daftar proyek</div>
  <a href="{{ route('admin.proyek.create') }}" class="btn-action btn-diterima" style="font-size:13px; padding:8px 16px;">+ Tambah Proyek</a>
</div>

@if($proyek->isEmpty())
  <div class="empty-state">Belum ada proyek. <a href="{{ route('admin.proyek.create') }}">Tambah sekarang</a>.</div>
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
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($proyek as $p)
      <tr>
        <td>
          <div style="font-weight:500; font-size:13px;">{{ $p->nama }}</div>
          <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">{{ Str::limit($p->deskripsi, 60) }}</div>
        </td>
        <td>{{ $p->lokasi }}</td>
        <td>
          @php
            $badge = ['berlangsung'=>'status-selesai','perencanaan'=>'status-menunggu','selesai'=>'status-diterima'][$p->status] ?? '';
            $label = ['berlangsung'=>'Berlangsung','perencanaan'=>'Perencanaan','selesai'=>'Selesai'][$p->status] ?? $p->status;
          @endphp
          <span class="status-badge {{ $badge }}">{{ $label }}</span>
        </td>
        <td>{{ $p->tanggal_mulai?->format('d M Y') ?? '—' }}</td>
        <td>{{ $p->tanggal_selesai?->format('d M Y') ?? '—' }}</td>
        <td>
          <div class="action-btns">
            <a href="{{ route('admin.proyek.edit', $p->id) }}" class="btn-action btn-edit">Edit</a>
            <form action="{{ route('admin.proyek.destroy', $p->id) }}" method="POST"
                  onsubmit="return confirm('Hapus proyek {{ $p->nama }}?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-action btn-delete">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="pagination-wrap">{{ $proyek->links() }}</div>
@endif

@endsection