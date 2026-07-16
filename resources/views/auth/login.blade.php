@extends('layouts.app')

@section('title', 'Login Akun')

@section('content')
<div class="auth-wrapper">
    <div class="auth-bg-gradient-1"></div>
    <div class="auth-bg-gradient-2"></div>
    
    <div class="auth-container">
        <div class="glass-card auth-card">
            <div class="auth-header">
                <a href="{{ route('home') }}" class="logo auth-logo">
                    <i class="bx bxs-shopping-bag logo-icon"></i>
                    <span>Nia Store</span>
                </a>
                <h2>Selamat Datang Kembali</h2>
                <p>Silakan masuk menggunakan email dan password akun Anda.</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="auth-error-alert">
                    <i class="bx bxs-error-circle text-danger"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span><br>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="auth-success-alert">
                    <i class="bx bxs-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="email"><i class="bx bx-envelope"></i> Alamat Email</label>
                    <input type="email" name="email" id="email" placeholder="Masukkan email Anda..." value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="bx bx-lock-alt"></i> Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password..." required>
                </div>

                <div class="form-row-auth">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="checkmark"></span>
                        Ingat Saya
                    </label>
                    <a href="#" class="forgot-link">Lupa Password?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-auth">
                    Masuk Sekarang <i class="bx bx-log-in"></i>
                </button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Gratis</a>
            </div>
        </div>
    </div>
</div>
@endsection
