@extends('layouts.app')
@section('title', 'Beranda')
@section('content')

<!-- HERO -->
<section class="hero">
  <div class="hero-pill">
    <div class="hero-dot"></div>
    Informasi Fasilitas Publik
  </div>
  <h1>Fasilitas kota yang <span class="hero-accent">terbuka</span> untuk semua warga</h1>
  <p>Temukan informasi lengkap tentang fasilitas publik di kota Anda — jam operasional, kondisi terkini, dan proyek pembangunan yang sedang berjalan.</p>
</section>

<!-- INFO STRIP (real stats from DB) -->
<div class="info-strip">
  @foreach ($stats as $s)
  <div class="info-strip-item">
    <div class="info-num">{{ $s['num'] }}</div>
    <div class="info-label">{{ $s['label'] }}</div>
  </div>
  @endforeach
</div>

<!-- FACILITIES -->
<div class="section">
  <div class="section-header">
    <div class="section-title">Fasilitas publik</div>
  </div>

  @if($facilities->isEmpty())
    <p style="font-size:13px; color:var(--text-muted);">Belum ada fasilitas yang ditambahkan.</p>
  @else
<div class="fac-grid">
  @foreach ($facilities as $f)
  <a href="{{ route('fasilitas.show', $f->id) }}" class="fac-card">

    <div class="fac-photo">
      @if($f->photo && file_exists(public_path('images/fasilitas/' . $f->photo)))
        <img src="{{ asset('images/fasilitas/' . $f->photo) }}" alt="{{ $f->name }}">
      @else
        <div class="fac-photo-placeholder">{{ strtoupper(substr($f->name, 0, 1)) }}</div>
      @endif
    </div>

    <div class="fac-body">
      <div class="fac-top-row">
        <div class="fac-name">{{ $f->name }}</div>
        <span class="tag {{ $f->status === 'open' ? 'tag-open' : 'tag-maint' }}">
          {{ $f->status === 'open' ? 'Buka' : 'Renovasi' }}
        </span>
      </div>
      <div class="fac-addr">{{ $f->address }}</div>
      <div class="fac-chips">
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
          {{ $f->created_at?->format('d M Y') }}
        </span>
      </div>
    </div>

  </a>
  @endforeach
</div>
  @endif

  <hr class="divider">

  <!-- PENGUMUMAN -->
  <div class="section-header">
    <div class="section-title">Pengumuman terbaru</div>
  </div>

  @if($pengumuman->isEmpty())
    <p style="font-size:13px; color:var(--text-muted);">Belum ada pengumuman.</p>
  @else
  <div class="news-list">
    @foreach ($pengumuman as $p)
    <div class="news-item">
      <div class="news-date-block">
        <div class="news-date-day">{{ $p->tanggal->format('d') }}</div>
        <div class="news-date-mon">{{ $p->tanggal->translatedFormat('M') }}</div>
      </div>
      <div class="news-body">
        <h4>{{ $p->judul }}</h4>
        <p>{{ Str::limit($p->isi, 100) }}</p>
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>

@endsection