@vite(['resources/css/style.css', 'resources/css/admin.css'])

@extends('admin.layout')
@section('title', 'Ubah Password')

@section('content')

<div class="form-card" style="max-width:480px;">
  <div class="form-head">
    <h2>Ubah Password</h2>
    <p>Masukkan password saat ini lalu tentukan password baru Anda.</p>
  </div>

  @if($errors->any())
  <div class="form-errors">
    <ul>
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('admin.akun.password.update') }}" method="POST">
    @csrf

    <div class="fgroup">
      <label for="current_password">Password saat ini</label>
      <input type="password" id="current_password" name="current_password"
             placeholder="Masukkan password saat ini">
    </div>

    <div class="fgroup">
      <label for="password">Password baru</label>
      <input type="password" id="password" name="password"
             placeholder="Minimal 8 karakter">
    </div>

    <div class="fgroup">
      <label for="password_confirmation">Konfirmasi password baru</label>
      <input type="password" id="password_confirmation" name="password_confirmation"
             placeholder="Ulangi password baru">
    </div>

    <div style="display:flex; gap:10px; margin-top:8px;">
      <button type="submit" class="form-submit" style="flex:1;">
        Simpan Password Baru
      </button>
      <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Batal</a>
    </div>

  </form>
</div>

@endsection