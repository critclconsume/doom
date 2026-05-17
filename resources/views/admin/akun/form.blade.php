@vite(['resources/css/style.css', 'resources/css/admin.css'])

@extends('admin.layout')
@section('title', 'Tambah Akun Admin')

@section('content')

<div class="form-card" style="max-width:520px;">
  <div class="form-head">
    <h2>Tambah Akun Admin Baru</h2>
    <p>Akun yang dibuat akan langsung dapat digunakan untuk login ke panel admin.</p>
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

  <form action="{{ route('admin.akun.store') }}" method="POST">
    @csrf

    <div class="fgroup">
      <label for="name">Nama lengkap</label>
      <input type="text" id="name" name="name"
             placeholder="e.g. Budi Santoso"
             value="{{ old('name') }}">
    </div>

    <div class="fgroup">
      <label for="email">Alamat email</label>
      <input type="email" id="email" name="email"
             placeholder="e.g. budi@dinaspU.go.id"
             value="{{ old('email') }}">
    </div>

    <div class="fgroup">
      <label for="password">Password</label>
      <input type="password" id="password" name="password"
             placeholder="Minimal 8 karakter">
    </div>

    <div class="fgroup">
      <label for="password_confirmation">Konfirmasi password</label>
      <input type="password" id="password_confirmation" name="password_confirmation"
             placeholder="Ulangi password">
    </div>

    <div style="display:flex; gap:10px; margin-top:8px;">
      <button type="submit" class="form-submit" style="flex:1;">
        Buat Akun Admin
      </button>
      <a href="{{ route('admin.akun.index') }}" class="btn-cancel">Batal</a>
    </div>

  </form>
</div>

@endsection