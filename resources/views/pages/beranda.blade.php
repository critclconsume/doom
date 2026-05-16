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
          <div class="fac-photo-placeholder">{{ $f->name }}</div>
        @endif
      </div>
      <div class="fac-body">
        <div class="fac-name">{{ $f->name }}</div>
        <div class="fac-addr">{{ $f->address }}</div>
        <div class="fac-footer">
          <span class="tag {{ $f->status === 'open' ? 'tag-open' : 'tag-maint' }}">
            {{ $f->status === 'open' ? 'Buka' : 'Renovasi' }}
          </span>
          <span class="fac-type">{{ $f->type }}</span>
        </div>
      </div>
    </div>
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