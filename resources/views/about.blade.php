@extends('layouts.frontend')
@section('title', 'Tentang Kami')

@section('frontend_content')
<!-- About Section -->
<section id="about" class="about-section" style="padding-top: 120px; min-height: 80vh;">
    <div class="container about-container">
        <div class="about-image">
            <img src="{{ $settings['about_image_url'] ?? 'https://images.unsplash.com/photo-1556906781-9a412961c28c?q=80&w=800&auto=format&fit=crop' }}" alt="Sepatuku.id Store" class="about-img">
        </div>
        <div class="about-content">
            <span class="badge">Tentang Kami</span>
            <h2>Sepatuku.id — Destinasi Sepatu Terlengkap di Indonesia</h2>
            <p id="about-text-display">{{ $settings['about_text'] ?? 'Sepatuku.id adalah toko sepatu online terpercaya yang menghadirkan koleksi sepatu terlengkap untuk pria dan wanita. Dari sneakers kasual hingga sepatu formal elegan, kami berkomitmen menghadirkan produk original berkualitas dengan pengalaman belanja yang mudah dan menyenangkan.' }}</p>
            <div class="about-features">
                <div class="feature-item">
                    <i class="bx bx-medal feature-icon"></i>
                    <div><h4>100% Produk Original</h4><p>Semua sepatu adalah produk resmi bergaransi dari brand ternama dan terpercaya.</p></div>
                </div>
                <div class="feature-item">
                    <i class="bx bx-rocket feature-icon"></i>
                    <div><h4>Pengiriman Kilat</h4><p>Dikirim ke seluruh Indonesia dalam 1-3 hari kerja dengan packaging premium.</p></div>
                </div>
                <div class="feature-item">
                    <i class="bx bx-refresh feature-icon"></i>
                    <div><h4>Garansi 30 Hari</h4><p>Tidak cocok ukurannya? Tukar tambah atau refund dalam 30 hari tanpa ribet.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
