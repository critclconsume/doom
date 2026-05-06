@extends('admin.layout')
@section('title', 'Kelola Fasilitas')

@section('content')

<div class="admin-section-header" style="margin-bottom: 18px;">
  <div class="admin-section-title">Daftar fasilitas</div>
  <a href="{{ route('admin.fasilitas.create') }}" class="btn-primary">+ Tambah Fasilitas</a>
</div>

@if($fasilitas->isEmpty())
  <div class="empty-state">Belum ada fasilitas. <a href="{{ route('admin.fasilitas.create') }}">Tambah sekarang</a>.</div>
@else

<div class="fac-admin-grid">
  @foreach($fasilitas as $f)
  <div class="fac-admin-card">

    {{-- PHOTO --}}
    <div class="fac-admin-photo">
      @if($f->photo && file_exists(public_path('images/fasilitas/' . $f->photo)))
        <img src="{{ asset('images/fasilitas/' . $f->photo) }}" alt="{{ $f->name }}">
      @else
        <div class="fac-photo-placeholder">{{ $f->name }}</div>
      @endif
    </div>

    {{-- INFO --}}
    <div class="fac-admin-body">
      <div class="fac-admin-top">
        <div>
          <div class="fac-name">{{ $f->name }}</div>
          <div class="fac-addr">{{ $f->address }}</div>
        </div>
        <span class="tag {{ $f->status === 'open' ? 'tag-open' : 'tag-maint' }}">
          {{ $f->status === 'open' ? 'Buka' : 'Renovasi' }}
        </span>
      </div>
      <div class="fac-type" style="margin-top:4px;">{{ $f->type }}</div>
    </div>

    {{-- ACTIONS --}}
    <div class="fac-admin-actions">
      <a href="{{ route('admin.fasilitas.edit', $f->id) }}" class="btn-action btn-edit">Edit</a>

      <form action="{{ route('admin.fasilitas.destroy', $f->id) }}" method="POST"
            onsubmit="return confirm('Hapus fasilitas {{ $f->name }}? Tindakan ini tidak bisa dibatalkan.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-action btn-delete">Hapus</button>
      </form>
    </div>

  </div>
  @endforeach
</div>

@endif

@endsection
