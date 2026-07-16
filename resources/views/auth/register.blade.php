@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

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
                <h2>Daftar Akun Baru</h2>
                <p>Buat akun gratis untuk mulai berbelanja produk premium kami.</p>
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

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="name"><i class="bx bx-user"></i> Nama Lengkap</label>
                    <input type="text" name="name" id="name" placeholder="Masukkan nama lengkap Anda..." value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email"><i class="bx bx-envelope"></i> Alamat Email</label>
                    <input type="email" name="email" id="email" placeholder="Masukkan email Anda..." value="{{ old('email') }}" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password"><i class="bx bx-lock-alt"></i> Password</label>
                        <input type="password" name="password" id="password" placeholder="Min. 6 karakter..." required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation"><i class="bx bx-check-shield"></i> Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password..." required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-auth" style="margin-top: 10px;">
                    Daftar Akun Baru <i class="bx bx-user-plus"></i>
                </button>
            </form>

            <div class="auth-footer">
                Sudah memiliki akun? <a href="{{ route('login') }}">Masuk Disini</a>
            </div>
        </div>
    </div>
</div>
@endsection
