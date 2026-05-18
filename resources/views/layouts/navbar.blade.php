<nav class="navbar">
  <a href="{{ route('beranda') }}" class="nav-brand">
    <div class="nav-brand-icon">
      <img src="{{ asset('images/pu-logo.png') }}" alt="PU Logo" style="width:32px; height:32px; object-fit:contain; border-radius:6px;">
    </div>
    <div>
      <div class="nav-brand-name">Sistem Informasi Fasilitas Umum (SIFU)</div>
      <div class="nav-brand-sub">Dinas PUPR</div>
    </div>
  </a>

  <div class="nav-links">
    <a href="{{ route('beranda') }}" class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
    <a href="{{ route('proyek') }}"  class="nav-link {{ request()->routeIs('proyek')  ? 'active' : '' }}">Proyek</a>
    <a href="{{ route('panduan') }}" class="nav-link {{ request()->routeIs('panduan') ? 'active' : '' }}">Buku Panduan</a>
  </div>

  <div class="nav-right">
    <a href="{{ route('lapor') }}" class="nav-cta">Laporkan Masalah</a>

    @guest
      <a href="{{ route('admin.login') }}" class="nav-admin-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" y1="12" x2="3" y2="12"/>
        </svg>
        Login Admin
      </a>
    @endguest

    @auth
      <a href="{{ route('admin.mod') }}" class="nav-admin-btn nav-admin-active">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7" rx="1"/>
          <rect x="14" y="3" width="7" height="7" rx="1"/>
          <rect x="3" y="14" width="7" height="7" rx="1"/>
          <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        Panel Admin
      </a>
    @endauth
  </div>
</nav>