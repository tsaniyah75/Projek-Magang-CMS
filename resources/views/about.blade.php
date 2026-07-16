@extends('layouts.frontend')
@section('title', 'Tentang Kami')

@section('frontend_content')
<!-- About Section -->
<section id="about" class="about-section" style="padding-top: 120px; min-height: 80vh;">
    <div class="container about-container">
        <div class="about-image">
            <img src="{{ $settings['about_image_url'] ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop' }}" alt="Tim Nia Store" class="about-img">
        </div>
        <div class="about-content">
            <span class="badge">Tentang Kami</span>
            <h2>Misi Nia Store Dalam Menyediakan Kenyamanan Berbelanja</h2>
            <p id="about-text-display">{{ $settings['about_text'] ?? 'Nia Store adalah platform e-commerce pilihan yang menyediakan produk-produk kurasi terbaik. Komitmen kami adalah memberikan pengalaman berbelanja yang mudah, cepat, dan aman serta kualitas produk yang selalu terjaga.' }}</p>
            <div class="about-features">
                <div class="feature-item">
                    <i class="bx bx-medal feature-icon"></i>
                    <div><h4>Kualitas Terbaik</h4><p>Semua produk melalui quality control yang sangat ketat.</p></div>
                </div>
                <div class="feature-item">
                    <i class="bx bx-rocket feature-icon"></i>
                    <div><h4>Pengiriman Cepat</h4><p>Bekerja sama dengan logistik terpercaya untuk garansi barang cepat sampai.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
