@extends('admin.layout')
@section('title', 'Kelola Akun Admin')

@section('content')

<div class="admin-section-header" style="margin-bottom:18px;">
  <div class="admin-section-title">Daftar akun admin</div>
  <a href="{{ route('admin.akun.create') }}" class="btn-primary" style="font-size:13px;">
    + Tambah Akun
  </a>
</div>

<div class="admin-table-wrap">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Dibuat</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($akun as $a)
      <tr>
        <td>
          <div style="display:flex; align-items:center; gap:10px;">
            <div class="akun-avatar">{{ strtoupper(substr($a->name, 0, 1)) }}</div>
            <div>
              <div style="font-weight:500; font-size:13px;">{{ $a->name }}</div>
              @if($a->id === auth()->id())
                <div style="font-size:11px; color:var(--teal-700);">Akun Anda</div>
              @endif
            </div>
          </div>
        </td>
        <td style="font-size:13px;">{{ $a->email }}</td>
        <td style="font-size:13px;">{{ $a->created_at->format('d M Y') }}</td>
        <td>
          @if($a->id !== auth()->id())
          <form action="{{ route('admin.akun.destroy', $a->id) }}" method="POST"
                onsubmit="return confirm('Hapus akun {{ $a->name }}?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-action btn-delete">Hapus</button>
          </form>
          @else
            <span style="font-size:12px; color:var(--text-muted);">—</span>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection