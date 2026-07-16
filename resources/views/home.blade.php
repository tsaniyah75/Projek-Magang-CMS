@extends('layouts.frontend')
@section('title', 'Beranda')
@section('frontend_content')

    <!-- Hero Section -->
    <section id="home" class="hero" style="padding-top: 120px;">
        <div class="hero-bg-gradient"></div>
        <div class="container hero-container {{ $settings['hero_layout'] ?? 'hero-layout-right' }} {{ ($settings['hero_image_size'] ?? '') == 'wide' ? 'hero-size-wide' : (($settings['hero_image_size'] ?? '') == 'full' ? 'hero-size-full' : '') }}" id="hero-container-display">
            <div class="hero-content">
                <span class="badge">Koleksi Terbaru 2026</span>
                <h1 id="hero-title-display">{{ $settings['hero_title'] ?? 'Gaya Hidup Modern dengan Produk Berkualitas' }}</h1>
                <p id="hero-subtitle-display">{{ $settings['hero_subtitle'] ?? 'Temukan berbagai macam produk kebutuhan harian, teknologi terbaru, dan aksesoris rumah berkualitas tinggi dengan harga terbaik.' }}</p>
                <div class="hero-buttons">
                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg">Belanja Sekarang <i class="bx bx-right-arrow-alt"></i></a>
                    <a href="{{ route('about') }}" class="btn btn-outline btn-lg">Pelajari Selengkapnya</a>
                </div>
            </div>
            <div class="hero-image-container">
                <div class="glass-card hero-glass-card">
                    <img id="hero-image-display" src="{{ $settings['hero_image_url'] ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop' }}" alt="Featured Product" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container stats-container">
            <div class="stat-card"><h3>5K+</h3><p>Pelanggan Aktif</p></div>
            <div class="stat-card"><h3>24/7</h3><p>Layanan Pelanggan</p></div>
            <div class="stat-card"><h3>100%</h3><p>Keamanan Transaksi</p></div>
            <div class="stat-card"><h3>{{ $products->count() ?? 0 }}+</h3><p>Produk Terdaftar</p></div>
        </div>
    </section>



    <!-- Products Section -->
    <section id="products" class="products-section" >
    <div class="container">
        <div class="section-header">
            <h2>Katalog Produk</h2>
            <p>Jelajahi berbagai pilihan produk terbaik kami dengan harga terbaik.</p>
        </div>
        <div class="filter-controls">
            <form action="{{ route('products') }}" method="GET" class="search-form">
                <div class="search-box">
                    <i class="bx bx-search search-icon"></i>
                    <input type="text" name="search" placeholder="Cari produk impian Anda..." value="{{ request('search') }}">
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
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-img" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=600&auto=format&fit=crop';">
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
                    <h3>Produk Tidak Ditemukan</h3>
                    <p>Maaf, produk yang Anda cari tidak ada atau kategori masih kosong.</p>
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
            <img id="about-image-display" src="{{ $settings['about_image_url'] ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop' }}" alt="Tim Nia Store" class="about-img">
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

    <!-- Contact Section -->
    <section id="contact" class="contact-section" >
    <div class="container">
        <div class="section-header">
            <h2>Hubungi Kami</h2>
            <p>Kami siap membantu Anda kapan saja. Kirim pesan atau hubungi info kontak di bawah ini.</p>
        </div>
        <div class="contact-grid">
            <div class="contact-info-card glass-card">
                <h3>Informasi Kontak</h3>
                <p>Silakan hubungi kami melalui saluran berikut ini:</p>
                <div class="info-details">
                    <div class="info-item"><i class="bx bx-envelope"></i><div><span>Email Resmi</span><h4 id="contact-email-display">{{ $settings['contact_email'] ?? 'info@niastore.com' }}</h4></div></div>
                    <div class="info-item"><i class="bx bx-phone"></i><div><span>No. Telepon</span><h4 id="contact-phone-display">{{ $settings['contact_phone'] ?? '+62 812-3456-7890' }}</h4></div></div>
                    <div class="info-item"><i class="bx bx-map"></i><div><span>Alamat Kantor</span><h4 id="contact-address-display">{{ $settings['contact_address'] ?? 'Jl. Merdeka No. 45, Jakarta Pusat, Indonesia' }}</h4></div></div>
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
