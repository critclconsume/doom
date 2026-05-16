@extends('layouts.app')
@section('title', $fasilitas->name)

@section('content')

<div class="fdetail-wrap">

  {{-- BACK --}}
  <a href="{{ route('beranda') }}" class="fdetail-back">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <polyline points="15 18 9 12 15 6"/>
    </svg>
    Kembali ke Beranda
  </a>

  <div class="fdetail-layout">

    {{-- LEFT: IMAGE SLIDER --}}
    <div class="fdetail-gallery">
      <div class="fdetail-slider" id="slider">

        @if(count($photos) > 0)
          @foreach($photos as $i => $photo)
          <div class="fdetail-slide {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
            <img src="{{ asset('images/fasilitas/' . $photo) }}" alt="{{ $fasilitas->name }}">
          </div>
          @endforeach
        @else
          <div class="fdetail-slide active">
            <div class="fdetail-no-photo">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
                <polyline points="21 15 16 10 5 21"/>
              </svg>
              <span>Belum ada foto</span>
            </div>
          </div>
        @endif

        @if(count($photos) > 1)
        <button class="fdetail-arrow fdetail-arrow-left" onclick="slideGo(-1)">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
        </button>
        <button class="fdetail-arrow fdetail-arrow-right" onclick="slideGo(1)">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </button>
        @endif
      </div>

      {{-- THUMBNAILS --}}
      @if(count($photos) > 1)
      <div class="fdetail-thumbs" id="thumbs">
        @foreach($photos as $i => $photo)
        <div class="fdetail-thumb {{ $i === 0 ? 'active' : '' }}"
             data-index="{{ $i }}"
             onclick="slideTo({{ $i }})">
          <img src="{{ asset('images/fasilitas/' . $photo) }}" alt="foto {{ $i + 1 }}">
        </div>
        @endforeach
      </div>
      @endif

      {{-- DOT INDICATORS --}}
      @if(count($photos) > 1)
      <div class="fdetail-dots" id="dots">
        @foreach($photos as $i => $photo)
        <span class="fdetail-dot {{ $i === 0 ? 'active' : '' }}" onclick="slideTo({{ $i }})"></span>
        @endforeach
      </div>
      @endif
    </div>

    {{-- RIGHT: INFO --}}
    <div class="fdetail-info">

      <div class="fdetail-type-row">
        <span class="fdetail-type-chip">{{ $fasilitas->type }}</span>
        <span class="tag {{ $fasilitas->status === 'open' ? 'tag-open' : 'tag-maint' }}">
          {{ $fasilitas->status === 'open' ? '● Buka' : '● Renovasi' }}
        </span>
      </div>

      <h1 class="fdetail-name">{{ $fasilitas->name }}</h1>

      <div class="fdetail-divider"></div>

      <div class="fdetail-meta-list">
        <div class="fdetail-meta-item">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          <div>
            <div class="fdetail-meta-label">Alamat</div>
            <div class="fdetail-meta-val">{{ $fasilitas->address }}</div>
          </div>
        </div>

        <div class="fdetail-meta-item">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
          </svg>
          <div>
            <div class="fdetail-meta-label">Jenis fasilitas</div>
            <div class="fdetail-meta-val">{{ $fasilitas->type }}</div>
          </div>
        </div>

        <div class="fdetail-meta-item">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
          <div>
            <div class="fdetail-meta-label">Status operasional</div>
            <div class="fdetail-meta-val">
              {{ $fasilitas->status === 'open' ? 'Fasilitas ini sedang buka dan dapat digunakan' : 'Fasilitas sedang dalam renovasi / pemeliharaan' }}
            </div>
          </div>
        </div>

        <div class="fdetail-meta-item">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
          </svg>
          <div>
            <div class="fdetail-meta-label">Ditambahkan</div>
            <div class="fdetail-meta-val">{{ $fasilitas->created_at->translatedFormat('d F Y') }}</div>
          </div>
        </div>
      </div>

      <div class="fdetail-divider"></div>

      <a href="{{ route('lapor') }}" class="fdetail-lapor-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
          <line x1="12" y1="9" x2="12" y2="13"/>
          <line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        Laporkan Masalah Fasilitas Ini
      </a>

    </div>
  </div>
</div>

<script>
  let current = 0;
  const slides = document.querySelectorAll('.fdetail-slide');
  const thumbs = document.querySelectorAll('.fdetail-thumb');
  const dots   = document.querySelectorAll('.fdetail-dot');

  function slideTo(n) {
    slides[current].classList.remove('active');
    if (thumbs[current]) thumbs[current].classList.remove('active');
    if (dots[current])   dots[current].classList.remove('active');

    current = (n + slides.length) % slides.length;

    slides[current].classList.add('active');
    if (thumbs[current]) thumbs[current].classList.add('active');
    if (dots[current])   dots[current].classList.add('active');
  }

  function slideGo(dir) { slideTo(current + dir); }
</script>

@endsection