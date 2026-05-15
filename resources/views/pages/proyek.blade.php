@extends('layouts.app')
@section('title', 'Proyek')

@section('content')

<div class="section">
  <div class="section-header" style="margin-top: 8px;">
    <div class="section-title">Proyek pembangunan</div>
  </div>

  @if($proyek->isEmpty())
    <p style="font-size:13px; color:var(--text-muted);">Belum ada proyek yang ditambahkan.</p>
  @else
  <div class="proyek-list">
    @foreach ($proyek as $p)
    @php $map = $statusMap[$p->status] ?? $statusMap['selesai']; @endphp
    <div class="proyek-item">
      <div class="proyek-dot" style="background: {{ $map['dot'] }};"></div>
      <div class="proyek-info">
        <h4>{{ $p->nama }}</h4>
        <p>{{ $p->deskripsi }}</p>
      </div>
      <span class="proyek-badge {{ $map['class'] }}">
        {{ $map['label'] }}
      </span>
    </div>
    @endforeach
  </div>

  <div class="pagination-wrap" style="justify-content:center; margin-top:20px;">
    {{ $proyek->links() }}
  </div>
  @endif

  <div class="proyek-legend">
    <div class="legend-item"><span class="legend-dot" style="background:#1D9E75;"></span>Berlangsung</div>
    <div class="legend-item"><span class="legend-dot" style="background:#BA7517;"></span>Perencanaan</div>
    <div class="legend-item"><span class="legend-dot" style="background:#888780;"></span>Selesai</div>
  </div>
</div>

@endsection