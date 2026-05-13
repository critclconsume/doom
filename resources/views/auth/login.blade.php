@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>Admin Login</h1>
            <p>Silakan masuk untuk mengelola fasilitas dan laporan</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-login">
                    Masuk ke Dashboard
                </button>
            </div>
        </form>
    </div>
</div>
@endsection