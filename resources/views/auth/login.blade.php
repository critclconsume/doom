@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>Admin Login</h1>
            <p>Silakan masuk untuk mengelola sistem</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

       <form method="POST" action="{{ route('admin.login') }}">
            @csrf   <!-- ← This is very important -->

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>


            @if ($errors->any())
             <div style="background:#FCEBEB; border:0.5px solid #F7C1C1; border-radius:8px; padding:10px 14px; margin-bottom:16px; font-size:13px; color:#791F1F;">
               {{ $errors->first('email') }}
         </div>
     @endif

            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>
</div>
@endsection