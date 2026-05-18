<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - FasilitasKota')</title>
    
    @vite(['resources/css/app.css', 'resources/css/admin.css'])  
</head>
<body class="admin-body">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-brand-icon">
<div class="sidebar-brand-icon">
  <img src="{{ asset('images/pu-logo.png') }}" alt="PU Logo" 
       style="width:28px; height:28px; object-fit:contain; border-radius:4px;">
</div>
      </div>
      <div>
        <div class="sidebar-brand-name">Sistem Informasi Fasilitas Umum (SIFU)</div>
        <div class="sidebar-brand-sub">Panel Admin</div>
      </div>
    </div>

    <nav class="sidebar-nav">
      <div class="sidebar-section-label">Menu</div>

      <a href="{{ route('admin.dashboard') }}"
   class="sidebar-link {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.mod') ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <rect x="3" y="3" width="7" height="7" rx="1"/>
          <rect x="14" y="3" width="7" height="7" rx="1"/>
          <rect x="3" y="14" width="7" height="7" rx="1"/>
          <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        Dashboard
      </a>

      <a href="{{ route('admin.laporan.index') }}"
         class="sidebar-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="9" y1="13" x2="15" y2="13"/>
          <line x1="9" y1="17" x2="13" y2="17"/>
        </svg>
        Laporan Masalah
        @php $pending = \App\Models\Laporan::where('status','menunggu')->count(); @endphp
        @if($pending > 0)
          <span class="sidebar-badge">{{ $pending }}</span>
        @endif
      </a>

      <a href="{{ route('admin.fasilitas.index') }}"
         class="sidebar-link {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        Fasilitas
      </a>

      <a href="{{ route('admin.pengumuman.index') }}"
         class="sidebar-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 01-3.46 0"/>
        </svg>
        Pengumuman
      </a>

      <a href="{{ route('admin.proyek.index') }}"
         class="sidebar-link {{ request()->routeIs('admin.proyek.*') ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <rect x="2" y="7" width="20" height="14" rx="2"/>
          <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
          <line x1="12" y1="12" x2="12" y2="16"/>
          <line x1="10" y1="14" x2="14" y2="14"/>   
        </svg>
        Proyek
      </a>

      <a href="{{ route('admin.akun.index') }}"
   class="sidebar-link {{ request()->routeIs('admin.akun.*') ? 'active' : '' }}">
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
    <circle cx="9" cy="7" r="4"/>
    <path d="M23 21v-2a4 4 0 00-3-3.87"/>
    <path d="M16 3.13a4 4 0 010 7.75"/>
  </svg>
  Kelola Akun
</a>

  <a href="{{ route('admin.akun.password') }}" class="sidebar-password-link">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <rect x="3" y="11" width="18" height="11" rx="2"/>
      <path d="M7 11V7a5 5 0 0110 0v4"/>
    </svg>
    Ubah Password
  </a>
    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="sidebar-user-avatar">
          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
          <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
          <div class="sidebar-user-role">Administrator</div>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-logout">Keluar</button>
      </form>
    </div>
  </aside>

  <div class="admin-content">
    <div class="admin-topbar">
      <div class="admin-topbar-title">@yield('title')</div>
    </div>

    <div class="admin-page">
      @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
      @endif

      @yield('content')
    </div>
  </div>

</body>
</html>
