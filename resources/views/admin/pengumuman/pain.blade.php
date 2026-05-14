@extends('admin.layout')
@section('title', 'Pengumuman')

@section('content')

<div class="admin-section-header" style="margin-bottom: 18px;">
  <div class="admin-section-title">Daftar pengumuman</div>
  <a href="{{ route('admin.pengumuman.index') }}" class="btn-primary">+ Tambah Pengumuman</a>
</div>

@if($pengumuman->isEmpty())
  <div class="empty-state">
    Belum ada pengumuman.
    <a href="{{ route('admin.pengumuman.create') }}">Tambah sekarang</a>.
  </div>
@else

<div class="admin-table-wrap">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Judul</th>
        <th>Isi</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pengumuman as $p)
      <tr>
        <td style="white-space:nowrap;">
          {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
        </td>
        <td>{{ $p->judul }}</td>
        <td class="td-truncate">{{ Str::limit($p->isi, 80) }}</td>
        <td>
          @if($p->is_published)
            <span class="status-badge status-selesai">Dipublikasi</span>
          @else
            <span class="status-badge status-menunggu">Draft</span>
          @endif
        </td>
        <td>
          <div class="action-btns">
            <a href="{{ route('admin.pengumuman.edit', $p->id) }}"
               class="btn-action btn-edit">Edit</a>

            <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST"
                  onsubmit="return confirm('Hapus pengumuman ini?')">
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

<div class="pagination-wrap">
  {{ $pengumuman->links() }}
</div>

@endif

@endsection
