
@vite(['resources/css/style.css', 'resources/css/admin.css'])

@extends('admin.layout')
@section('title', 'Daftar Fasilitas')

@section('content')

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;">
  <div class="admin-section-title">Daftar fasilitas</div>
  <a href="{{ route('admin.fasilitas.create') }}" class="btn-action btn-diterima" style="font-size:13px; padding:8px 16px;">
    + Tambah Fasilitas
  </a>
</div>

@if($fasilitas->isEmpty())
  <div class="empty-state">
    Belum ada fasilitas. <a href="{{ route('admin.fasilitas.create') }}">Tambah sekarang</a>.
  </div>
@else

<div class="fac-admin-grid">
  @foreach($fasilitas as $f)
  <div class="fac-admin-card">

    {{-- PHOTO --}}
    <div class="fac-admin-photo">
      @if($f->photo && file_exists(public_path('images/fasilitas/' . $f->photo)))
        <img src="{{ asset('images/fasilitas/' . $f->photo) }}" alt="{{ $f->name }}">
      @else
        <div class="fac-photo-placeholder">{{ strtoupper(substr($f->name, 0, 1)) }}</div>
      @endif
    </div>

    {{-- BODY --}}
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

      <div class="fac-info-chips">
        <span class="fac-chip">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          {{ $f->type }}
        </span>
        <span class="fac-chip">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
          </svg>
          {{ $f->created_at->format('d M Y') }}
        </span>
      </div>
    </div>

    {{-- ACTIONS --}}
    <div class="fac-admin-actions">
      <a href="{{ route('admin.fasilitas.edit', $f->id) }}"
         class="btn-action btn-edit" style="flex:1; text-align:center;">Edit</a>
      <form action="{{ route('admin.fasilitas.destroy', $f->id) }}" method="POST"
            onsubmit="return confirm('Hapus fasilitas {{ addslashes($f->name) }}?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-action btn-delete">Hapus</button>
      </form>
    </div>

  </div>
  @endforeach
</div>

<div class="pagination-wrap">
  {{ $fasilitas->links() }}
</div>

@endif

@endsection