@extends('layouts.frontend')
@section('title', 'Beranda')
@section('frontend_content')

    <!-- Hero Section -->
    <section id="home" class="hero" style="padding-top: 120px;">
        <div class="hero-bg-gradient"></div>
        <div class="container hero-container {{ $settings['hero_layout'] ?? 'hero-layout-right' }} {{ ($settings['hero_image_size'] ?? '') == 'wide' ? 'hero-size-wide' : (($settings['hero_image_size'] ?? '') == 'full' ? 'hero-size-full' : '') }}" id="hero-container-display">
            <div class="hero-content">
                <span class="badge">Koleksi Terbaru 2026</span>
                <h1 id="hero-title-display">{{ $settings['hero_title'] ?? 'Langkah Percaya Diri dengan Sepatu Berkualitas' }}</h1>
                <p id="hero-subtitle-display">{{ $settings['hero_subtitle'] ?? 'Temukan berbagai koleksi sepatu terbaru mulai dari sneakers, formal, hingga olahraga dengan kenyamanan terbaik dan desain kekinian.' }}</p>
                <div class="hero-buttons">
                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg">Belanja Sekarang <i class="bx bx-right-arrow-alt"></i></a>
                    <a href="{{ route('about') }}" class="btn btn-outline btn-lg">Pelajari Selengkapnya</a>
                </div>
            </div>
            <div class="hero-image-container">
                <div class="glass-card hero-glass-card">
                    <img id="hero-image-display" src="{{ $settings['hero_image_url'] ?? 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=600&auto=format&fit=crop' }}" alt="Featured Shoe" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container stats-container">
            <div class="stat-card glass-hover">
                <div class="stat-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>5K+</h3>
                <p>Pelanggan Setia</p>
            </div>
            <div class="stat-card glass-hover">
                <div class="stat-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>24/7</h3>
                <p>Layanan Pelanggan</p>
            </div>
            <div class="stat-card glass-hover">
                <div class="stat-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3>100%</h3>
                <p>Jaminan Original</p>
            </div>
            <div class="stat-card glass-hover">
                <div class="stat-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3>{{ $products->count() ?? 0 }}+</h3>
                <p>Model Sepatu</p>
            </div>
        </div>
    </section>



    <!-- Products Section -->
    <section id="products" class="products-section" >
    <div class="container">
        <div class="section-header">
            <h2>Katalog Sepatu</h2>
            <p>Jelajahi berbagai pilihan sepatu terbaik kami untuk melengkapi gaya Anda.</p>
        </div>
        <div class="filter-controls">
            <form action="{{ route('products') }}" method="GET" class="search-form">
                <div class="search-box">
                    <i class="bx bx-search search-icon"></i>
                    <input type="text" name="search" placeholder="Cari sepatu impian Anda..." value="{{ request('search') }}">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
            <div class="category-tabs">
                <a href="{{ route('products', ['search' => request('search')]) }}" class="tab-btn {{ !request('category') ? 'active' : '' }}">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('products', ['category' => $cat->slug, 'search' => request('search')]) }}" class="tab-btn {{ request('category') == $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card" onclick="openProductModal({{ json_encode($product) }})">
                    <div class="product-image-wrapper">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-img" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format&fit=crop';">
                        <span class="product-category-tag">{{ $product->category->name ?? 'Umum' }}</span>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-desc-short">{{ Str::limit($product->description, 70) }}</p>
                        <div class="product-footer">
                            <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="product-stock-tag {{ $product->stock > 5 ? 'in-stock' : 'low-stock' }}">Stok: {{ $product->stock }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bx bx-package empty-icon"></i>
                    <h3>Sepatu Tidak Ditemukan</h3>
                    <p>Maaf, sepatu yang Anda cari tidak ada atau kategori sedang kosong.</p>
                    <a href="{{ route('products') }}" class="btn btn-outline">Reset Filter</a>
                </div>
            @endforelse
        </div>
    </div>
</section>

    <!-- About Section -->
    <section id="about" class="about-section" >
    <div class="container about-container">
        <div class="about-image">
            <img id="about-image-display" src="{{ $settings['about_image_url'] ?? 'https://images.unsplash.com/photo-1556906781-9a412961c28c?q=80&w=800&auto=format&fit=crop' }}" alt="Tim Sepatuku" class="about-img">
        </div>
        <div class="about-content">
            <span class="badge">Tentang Kami</span>
            <h2>Sepatuku.id - Melangkah dengan Nyaman Setiap Hari</h2>
            <p id="about-text-display">{{ $settings['about_text'] ?? 'Sepatuku.id adalah destinasi utama untuk para pencinta alas kaki. Kami berkomitmen untuk menyediakan pilihan sepatu dengan kualitas material terbaik dan desain yang selalu mengikuti tren terkini untuk menemani setiap langkah Anda.' }}</p>
            <div class="about-features">
                <div class="feature-item">
                    <i class="bx bx-medal feature-icon"></i>
                    <div><h4>Kualitas Premium</h4><p>Kami hanya menjual produk sepatu dengan material pilihan dan awet.</p></div>
                </div>
                <div class="feature-item">
                    <i class="bx bx-rocket feature-icon"></i>
                    <div><h4>Pengiriman Kilat</h4><p>Layanan pengiriman cepat untuk memastikan sepatu sampai tepat di depan pintu Anda.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section" >
    <div class="container">
        <div class="section-header">
            <h2>Hubungi Kami</h2>
            <p>Punya pertanyaan tentang ukuran atau stok sepatu? Tim kami siap membantu Anda.</p>
        </div>
        <div class="contact-grid">
            <div class="contact-info-card glass-card">
                <h3>Informasi Kontak</h3>
                <p>Silakan hubungi kami melalui saluran berikut ini:</p>
                <div class="info-details">
                    <div class="info-item"><i class="bx bx-envelope"></i><div><span>Email Resmi</span><h4 id="contact-email-display">{{ $settings['contact_email'] ?? 'halo@sepatuku.id' }}</h4></div></div>
                    <div class="info-item"><i class="bx bx-phone"></i><div><span>No. Telepon</span><h4 id="contact-phone-display">{{ $settings['contact_phone'] ?? '+62 812-3456-7890' }}</h4></div></div>
                    <div class="info-item"><i class="bx bx-map"></i><div><span>Showroom</span><h4 id="contact-address-display">{{ $settings['contact_address'] ?? 'Jl. Langkah Baru No. 10, Jakarta Selatan' }}</h4></div></div>
                </div>
            </div>
            <form action="{{ route('contact.store') }}" method="POST" class="contact-form glass-card">
                @csrf
                <h3>Kirim Pesan</h3>
                <div class="form-group"><label for="contact-name">Nama Lengkap</label><input type="text" name="name" id="contact-name" placeholder="Masukkan nama Anda..." required></div>
                <div class="form-group"><label for="contact-email-input">Alamat Email</label><input type="email" name="email" id="contact-email-input" placeholder="Masukkan email Anda..." required></div>
                <div class="form-group"><label for="contact-msg">Pesan Anda</label><textarea name="message" id="contact-msg" rows="4" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required></textarea></div>
                <button type="submit" class="btn btn-primary btn-block">Kirim Pesan <i class="bx bx-send"></i></button>
            </form>
        </div>
    </div>
</section>

@endsection
