@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Navigation Bar -->
    <header class="header">
        <div class="container nav-container">
            <a href="#" class="logo">
                <i class="bx bxs-shopping-bag logo-icon"></i>
                <span id="logo-text">{{ $settings['shop_name'] ?? 'Nia Store' }}</span>
            </a>
            
            <nav class="nav-links">
                <a href="#home" class="active">Beranda</a>
                <a href="#products">Produk</a>
                <a href="#about">Tentang Kami</a>
                <a href="#contact">Kontak</a>
            </nav>

            <div class="nav-actions">
                <button class="btn btn-primary btn-cms" onclick="toggleCmsDrawer()">
                    <i class="bx bx-cog icon-spin"></i> CMS Admin
                </button>
            </div>
        </div>
    </header>

    <!-- Success / Error Toast -->
    @if(session('success'))
        <div class="toast success-toast" id="toast-message">
            <i class="bx bxs-check-circle toast-icon"></i>
            <span class="toast-text">{{ session('success') }}</span>
            <button class="toast-close" onclick="closeToast()">&times;</button>
        </div>
    @endif
    @if($errors->any())
        <div class="toast error-toast" id="toast-message">
            <i class="bx bxs-error-circle toast-icon"></i>
            <span class="toast-text">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </span>
            <button class="toast-close" onclick="closeToast()">&times;</button>
        </div>
    @endif

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-bg-gradient"></div>
        <div class="container hero-container">
            <div class="hero-content">
                <span class="badge">Koleksi Terbaru 2026</span>
                <h1 id="hero-title-display">{{ $settings['hero_title'] ?? 'Gaya Hidup Modern dengan Produk Berkualitas' }}</h1>
                <p id="hero-subtitle-display">{{ $settings['hero_subtitle'] ?? 'Temukan berbagai macam produk kebutuhan harian, teknologi terbaru, dan aksesoris rumah berkualitas tinggi dengan harga terbaik.' }}</p>
                <div class="hero-buttons">
                    <a href="#products" class="btn btn-primary btn-lg">Belanja Sekarang <i class="bx bx-right-arrow-alt"></i></a>
                    <a href="#about" class="btn btn-outline btn-lg">Pelajari Selengkapnya</a>
                </div>
            </div>
            <div class="hero-image-container">
                <div class="glass-card hero-glass-card">
                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop" alt="Featured Product" class="hero-image">
                    <div class="floating-badge badge-top">
                        <i class="bx bxs-star yellow"></i> 4.9 Rating
                    </div>
                    <div class="floating-badge badge-bottom">
                        <i class="bx bxs-check-shield green"></i> Garansi Resmi 1 Tahun
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container stats-container">
            <div class="stat-card">
                <h3>5K+</h3>
                <p>Pelanggan Aktif</p>
            </div>
            <div class="stat-card">
                <h3>24/7</h3>
                <p>Layanan Pelanggan</p>
            </div>
            <div class="stat-card">
                <h3>100%</h3>
                <p>Keamanan Transaksi</p>
            </div>
            <div class="stat-card">
                <h3>{{ $products->count() }}+</h3>
                <p>Produk Terdaftar</p>
            </div>
        </div>
    </section>

    <!-- Products Catalog Section -->
    <section id="products" class="products-section">
        <div class="container">
            <div class="section-header">
                <h2>Katalog Produk</h2>
                <p>Jelajahi berbagai pilihan produk terbaik kami dengan harga terbaik.</p>
            </div>

            <!-- Search & Filters -->
            <div class="filter-controls">
                <form action="{{ route('home') }}#products" method="GET" class="search-form">
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
                    <a href="{{ route('home', ['search' => request('search')]) }}#products" class="tab-btn {{ !request('category') ? 'active' : '' }}">
                        Semua
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('home', ['category' => $cat->slug, 'search' => request('search')]) }}#products" class="tab-btn {{ request('category') == $cat->slug ? 'active' : '' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
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
                                <span class="product-stock-tag {{ $product->stock > 5 ? 'in-stock' : 'low-stock' }}">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bx bx-package empty-icon"></i>
                        <h3>Produk Tidak Ditemukan</h3>
                        <p>Maaf, produk yang Anda cari tidak ada atau kategori masih kosong.</p>
                        <a href="{{ route('home') }}#products" class="btn btn-outline">Reset Filter</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container about-container">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop" alt="Tim Nia Store" class="about-img">
            </div>
            <div class="about-content">
                <span class="badge">Tentang Kami</span>
                <h2>Misi Nia Store Dalam Menyediakan Kenyamanan Berbelanja</h2>
                <p id="about-text-display">{{ $settings['about_text'] ?? 'Nia Store adalah platform e-commerce pilihan yang menyediakan produk-produk kurasi terbaik. Komitmen kami adalah memberikan pengalaman berbelanja yang mudah, cepat, dan aman serta kualitas produk yang selalu terjaga.' }}</p>
                
                <div class="about-features">
                    <div class="feature-item">
                        <i class="bx bx-medal feature-icon"></i>
                        <div>
                            <h4>Kualitas Terbaik</h4>
                            <p>Semua produk melalui quality control yang sangat ketat.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="bx bx-rocket feature-icon"></i>
                        <div>
                            <h4>Pengiriman Cepat</h4>
                            <p>Bekerja sama dengan logistik terpercaya untuk garansi barang cepat sampai.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-header">
                <h2>Hubungi Kami</h2>
                <p>Kami siap membantu Anda kapan saja. Kirim pesan atau hubungi info kontak di bawah ini.</p>
            </div>

            <div class="contact-grid">
                <!-- Contact Info Card -->
                <div class="contact-info-card glass-card">
                    <h3>Informasi Kontak</h3>
                    <p>Silakan hubungi kami melalui saluran berikut ini:</p>
                    
                    <div class="info-details">
                        <div class="info-item">
                            <i class="bx bx-envelope"></i>
                            <div>
                                <span>Email Resmi</span>
                                <h4 id="contact-email-display">{{ $settings['contact_email'] ?? 'info@niastore.com' }}</h4>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="bx bx-phone"></i>
                            <div>
                                <span>No. Telepon</span>
                                <h4 id="contact-phone-display">{{ $settings['contact_phone'] ?? '+62 812-3456-7890' }}</h4>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="bx bx-map"></i>
                            <div>
                                <span>Alamat Kantor</span>
                                <h4 id="contact-address-display">{{ $settings['contact_address'] ?? 'Jl. Merdeka No. 45, Jakarta Pusat, Indonesia' }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form (Actual POST to DB) -->
                <form action="{{ route('contact.store') }}" method="POST" class="contact-form glass-card">
                    @csrf
                    <h3>Kirim Pesan</h3>
                    <div class="form-group">
                        <label for="contact-name">Nama Lengkap</label>
                        <input type="text" name="name" id="contact-name" placeholder="Masukkan nama Anda..." required>
                    </div>
                    <div class="form-group">
                        <label for="contact-email-input">Alamat Email</label>
                        <input type="email" name="email" id="contact-email-input" placeholder="Masukkan email Anda..." required>
                    </div>
                    <div class="form-group">
                        <label for="contact-msg">Pesan Anda</label>
                        <textarea name="message" id="contact-msg" rows="4" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Kirim Pesan <i class="bx bx-send"></i></button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-container">
            <div class="footer-brand">
                <a href="#" class="logo">
                    <i class="bx bxs-shopping-bag logo-icon"></i>
                    <span>{{ $settings['shop_name'] ?? 'Nia Store' }}</span>
                </a>
                <p>E-commerce modern dengan kemudahan akses langsung pengeditan halaman (CMS) secara dinamis.</p>
                <div class="social-links">
                    <a href="#"><i class="bx bxl-facebook"></i></a>
                    <a href="#"><i class="bx bxl-instagram"></i></a>
                    <a href="#"><i class="bx bxl-twitter"></i></a>
                    <a href="#"><i class="bx bxl-linkedin"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h4>Navigasi</h4>
                <a href="#home">Beranda</a>
                <a href="#products">Katalog Produk</a>
                <a href="#about">Tentang Kami</a>
                <a href="#contact">Hubungi Kami</a>
            </div>
            <div class="footer-links">
                <h4>Kategori</h4>
                @foreach($categories->take(4) as $cat)
                    <a href="{{ route('home', ['category' => $cat->slug]) }}#products">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 <span id="footer-shop-name">{{ $settings['shop_name'] ?? 'Nia Store' }}</span>. Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </footer>


    <!-- PRODUCT DETAIL MODAL -->
    <div class="modal-overlay" id="product-modal">
        <div class="modal-card">
            <button class="modal-close" onclick="closeProductModal()">&times;</button>
            <div class="modal-grid">
                <div class="modal-img-container">
                    <img id="modal-product-img" src="" alt="">
                </div>
                <div class="modal-details">
                    <span class="modal-category" id="modal-product-category">Kategori</span>
                    <h2 id="modal-product-title">Nama Produk</h2>
                    <span class="modal-price" id="modal-product-price">Rp 0</span>
                    <p class="modal-description" id="modal-product-desc">Deskripsi lengkap produk.</p>
                    <div class="modal-meta">
                        <span class="stock-indicator" id="modal-product-stock">Stok Tersedia: 0</span>
                    </div>
                    <div class="modal-actions">
                        <button class="btn btn-primary" id="buy-now-btn" onclick="openCheckoutModal()">
                            <i class="bx bx-cart-add"></i> Beli Sekarang
                        </button>
                        <button class="btn btn-outline" onclick="closeProductModal()">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- CHECKOUT FORM MODAL -->
    <div class="modal-overlay" id="checkout-modal">
        <div class="modal-card modal-card-sm">
            <button class="modal-close" onclick="closeCheckoutModal()">&times;</button>
            <div class="modal-details">
                <span class="modal-category">Formulir Pembelian</span>
                <h2 style="font-size: 1.5rem; margin-bottom: 8px;">Checkout: <span id="checkout-prod-name">Produk</span></h2>
                <span class="modal-price" id="checkout-prod-price" style="font-size: 1.25rem; margin-bottom: 20px;">Rp 0</span>
                
                <form action="{{ route('checkout.process') }}" method="POST" class="cms-form">
                    @csrf
                    <input type="hidden" name="product_id" id="checkout-product-id">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="co-qty">Kuantitas / Jumlah</label>
                            <input type="number" name="quantity" id="co-qty" value="1" min="1" oninput="calculateTotalCheckout()" required>
                        </div>
                        <div class="form-group">
                            <label>Total Bayar</label>
                            <input type="text" id="co-total-display" value="Rp 0" readonly style="font-weight: 700; color: var(--primary); background: #f1f5f9;">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="co-name">Nama Penerima</label>
                        <input type="text" name="customer_name" id="co-name" placeholder="Nama lengkap Anda..." required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="co-email">Email</label>
                            <input type="email" name="customer_email" id="co-email" placeholder="email@domain.com" required>
                        </div>
                        <div class="form-group">
                            <label for="co-phone">No. Handphone / WA</label>
                            <input type="text" name="customer_phone" id="co-phone" placeholder="Contoh: 0812..." required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="co-address">Alamat Lengkap Pengiriman</label>
                        <textarea name="customer_address" id="co-address" rows="3" placeholder="Masukkan alamat lengkap rumah Anda..." required></textarea>
                    </div>

                    <div class="modal-actions" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary btn-block">Konfirmasi & Pesan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- CMS SLIDE-OUT DRAWER PANEL (Top-Right Toggle) -->
    <div class="cms-overlay" id="cms-drawer">
        <div class="cms-drawer-card">
            <div class="cms-drawer-header">
                <h3><i class="bx bxs-dashboard"></i> CMS Control Center</h3>
                <button class="cms-close-btn" onclick="toggleCmsDrawer()">&times;</button>
            </div>
            
            <!-- CMS Navigation Tabs -->
            <div class="cms-tabs">
                <button class="cms-tab-btn active" onclick="switchCmsTab('edit-site')">
                    <i class="bx bx-edit-alt"></i> Edit Tampilan
                </button>
                <button class="cms-tab-btn" onclick="switchCmsTab('manage-products')">
                    <i class="bx bx-grid-alt"></i> Produk & Kategori
                </button>
                <button class="cms-tab-btn" onclick="switchCmsTab('orders-tracker')">
                    <i class="bx bx-list-check"></i> Pesanan <span class="cms-badge-count">{{ $orders->where('status','Baru')->count() }}</span>
                </button>
                <button class="cms-tab-btn" onclick="switchCmsTab('inbox-messages')">
                    <i class="bx bx-envelope"></i> Inbox <span class="cms-badge-count">{{ $messages->count() }}</span>
                </button>
            </div>

            <!-- Tab Content 1: Edit Site Settings -->
            <div class="cms-tab-content active" id="tab-edit-site">
                <form action="{{ route('cms.settings.update') }}" method="POST" class="cms-form">
                    @csrf
                    <div class="cms-section-title">Informasi Toko</div>
                    <div class="form-group">
                        <label for="input-shop_name">Nama Toko</label>
                        <input type="text" name="shop_name" id="input-shop_name" value="{{ $settings['shop_name'] ?? 'Nia Store' }}" oninput="previewText('logo-text', this.value); previewText('footer-shop-name', this.value);" required>
                    </div>

                    <div class="cms-section-title">Bagian Hero Banner</div>
                    <div class="form-group">
                        <label for="input-hero_title">Judul Banner Utama</label>
                        <input type="text" name="hero_title" id="input-hero_title" value="{{ $settings['hero_title'] ?? '' }}" oninput="previewText('hero-title-display', this.value);" required>
                    </div>
                    <div class="form-group">
                        <label for="input-hero_subtitle">Sub-judul / Deskripsi Banner</label>
                        <textarea name="hero_subtitle" id="input-hero_subtitle" rows="3" oninput="previewText('hero-subtitle-display', this.value);" required>{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                    </div>

                    <div class="cms-section-title">Bagian Tentang Kami (About)</div>
                    <div class="form-group">
                        <label for="input-about_text">Deskripsi Tentang Kami</label>
                        <textarea name="about_text" id="input-about_text" rows="4" oninput="previewText('about-text-display', this.value);" required>{{ $settings['about_text'] ?? '' }}</textarea>
                    </div>

                    <div class="cms-section-title">Informasi Kontak & Footer</div>
                    <div class="form-group">
                        <label for="input-contact_email">Email Kontak</label>
                        <input type="email" name="contact_email" id="input-contact_email" value="{{ $settings['contact_email'] ?? '' }}" oninput="previewText('contact-email-display', this.value);" required>
                    </div>
                    <div class="form-group">
                        <label for="input-contact_phone">No. Telepon / WA</label>
                        <input type="text" name="contact_phone" id="input-contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" oninput="previewText('contact-phone-display', this.value);" required>
                    </div>
                    <div class="form-group">
                        <label for="input-contact_address">Alamat Fisik</label>
                        <textarea name="contact_address" id="input-contact_address" rows="2" oninput="previewText('contact-address-display', this.value);" required>{{ $settings['contact_address'] ?? '' }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan Web</button>
                </form>
            </div>

            <!-- Tab Content 2: Manage Products & Categories -->
            <div class="cms-tab-content" id="tab-manage-products">
                <div class="cms-actions-bar" style="display:flex; gap:10px;">
                    <button class="btn btn-emerald btn-sm" onclick="showAddProductForm()">
                        <i class="bx bx-plus"></i> Tambah Produk
                    </button>
                    <button class="btn btn-outline btn-sm" onclick="toggleCategorySection()" style="color:white; border-color:rgba(255,255,255,0.2);">
                        <i class="bx bx-category"></i> Kelola Kategori
                    </button>
                </div>

                <!-- CATEGORIES CRUD SUB-SECTION -->
                <div class="cms-product-form-container" id="cms-category-crud-container" style="display:none; margin-bottom:20px;">
                    <div class="cms-form-sub-header">
                        <h4>Kelola Kategori Database</h4>
                        <button class="btn-text-close" onclick="toggleCategorySection()">&times; Tutup</button>
                    </div>
                    <form action="{{ route('cms.categories.store') }}" method="POST" class="cms-form" style="margin-bottom:20px;">
                        @csrf
                        <div class="form-group" style="display:flex; gap:10px; margin-bottom:0;">
                            <input type="text" name="name" placeholder="Nama kategori baru..." required style="flex:1;">
                            <button type="submit" class="btn btn-emerald btn-sm" style="padding:10px 15px;">Tambah</button>
                        </div>
                    </form>
                    <div class="cms-category-list-sub">
                        @foreach($categories as $cat)
                            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:rgba(255,255,255,0.04); border-radius:6px; margin-bottom:6px;">
                                <span>{{ $cat->name }} ({{ $cat->products->count() }} produk)</span>
                                @if($cat->id != 4) {{-- Category Umum cannot be deleted easily for safety --}}
                                    <form action="{{ route('cms.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Menghapus kategori juga akan menghapus produk di dalamnya. Hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:transparent; border:none; color:var(--danger); cursor:pointer;"><i class="bx bx-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- PRODUCT ADD / EDIT FORM -->
                <div class="cms-product-form-container" id="cms-product-form-container" style="display: none;">
                    <div class="cms-form-sub-header">
                        <h4 id="product-form-title">Tambah Produk Baru</h4>
                        <button class="btn-text-close" onclick="hideProductForm()">&times; Batal</button>
                    </div>
                    <form id="product-crud-form" action="{{ route('cms.products.store') }}" method="POST" enctype="multipart/form-data" class="cms-form">
                        @csrf
                        <input type="hidden" name="_method" id="product-form-method" value="POST">
                        <div class="form-group">
                            <label for="p-name">Nama Produk</label>
                            <input type="text" name="name" id="p-name" required placeholder="Masukkan nama produk...">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="p-price">Harga (Rp)</label>
                                <input type="number" name="price" id="p-price" required min="0" placeholder="Contoh: 150000">
                            </div>
                            <div class="form-group">
                                <label for="p-stock">Stok</label>
                                <input type="number" name="stock" id="p-stock" required min="0" value="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="p-category-id">Kategori</label>
                            <select name="category_id" id="p-category-id" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="p-image-url">URL Gambar (Opsional)</label>
                            <input type="text" name="image_url" id="p-image-url" placeholder="https://images.unsplash.com/...">
                        </div>
                        <div class="form-group">
                            <label for="p-image">Upload File Gambar (Opsional, max 2MB)</label>
                            <input type="file" name="image" id="p-image" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="p-description">Deskripsi Produk</label>
                            <textarea name="description" id="p-description" rows="3" placeholder="Tuliskan spesifikasi dan penjelasan produk secara lengkap..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-emerald btn-block" id="product-form-submit-btn">Simpan Produk</button>
                    </form>
                </div>

                <!-- Product Inventory List -->
                <div class="cms-product-list" id="cms-inventory-list">
                    <div class="cms-section-title">Daftar Produk Aktif</div>
                    @foreach($products as $prod)
                        <div class="cms-product-item">
                            <div class="cms-product-item-img">
                                <img src="{{ $prod->image_url }}" alt="" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=600&auto=format&fit=crop';">
                            </div>
                            <div class="cms-product-item-info">
                                <h4>{{ $prod->name }}</h4>
                                <span>Rp {{ number_format($prod->price, 0, ',', '.') }} | Kategori: {{ $prod->category->name ?? 'Umum' }}</span>
                            </div>
                            <div class="cms-product-item-actions">
                                <button class="btn btn-outline btn-icon-sm" onclick='fillEditProductForm(@json($prod))' title="Edit">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <form action="{{ route('cms.products.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon-sm" title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    @if($products->isEmpty())
                        <p class="empty-text">Tidak ada produk. Silakan tambahkan produk baru.</p>
                    @endif
                </div>
            </div>

            <!-- Tab Content 3: Orders Tracker -->
            <div class="cms-tab-content" id="tab-orders-tracker">
                <div class="cms-section-title">Transaksi Penjualan Pelanggan</div>
                
                @forelse($orders as $order)
                    <div class="cms-order-card">
                        <div class="cms-order-card-header">
                            <div>
                                <strong>#{{ $order->id }} - {{ $order->customer_name }}</strong>
                                <span class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            
                            <!-- Status Update Form -->
                            <form action="{{ route('cms.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" class="status-select select-status-{{ Str::lower($order->status) }}" onchange="this.form.submit()">
                                    <option value="Baru" {{ $order->status == 'Baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="Dibayar" {{ $order->status == 'Dibayar' ? 'selected' : '' }}>Dibayar</option>
                                    <option value="Dikirim" {{ $order->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Dibatalkan" {{ $order->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </form>
                        </div>
                        <div class="cms-order-card-body">
                            <div class="order-info-row">
                                <span><i class="bx bx-phone"></i> {{ $order->customer_phone }}</span>
                                <span><i class="bx bx-envelope"></i> {{ $order->customer_email }}</span>
                            </div>
                            <div class="order-info-address">
                                <strong>Alamat:</strong> {{ $order->customer_address }}
                            </div>
                            
                            <div class="order-items-list-sub">
                                <strong>Produk yang dibeli:</strong>
                                @foreach($order->items as $item)
                                    <div class="order-item-desc-row">
                                        <span>{{ $item->product->name ?? 'Produk Dihapus' }} (x{{ $item->quantity }})</span>
                                        <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="order-total-row">
                                <span>Total Tagihan:</span>
                                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="empty-text">Belum ada transaksi pembelian masuk.</p>
                @endforelse
            </div>

            <!-- Tab Content 4: Inbox Messages -->
            <div class="cms-tab-content" id="tab-inbox-messages">
                <div class="cms-section-title">Pesan Hubungi Kami Masuk</div>
                
                @forelse($messages as $msg)
                    <div class="cms-message-card">
                        <div class="cms-message-card-header">
                            <div>
                                <strong>{{ $msg->name }}</strong>
                                <span class="message-email">&lt;{{ $msg->email }}&gt;</span>
                            </div>
                            <form action="{{ route('cms.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan kontak ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-msg-delete" title="Hapus Pesan"><i class="bx bx-trash"></i></button>
                            </form>
                        </div>
                        <div class="cms-message-card-body">
                            <p>"{{ $msg->message }}"</p>
                            <span class="message-date">{{ $msg->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="empty-text">Kotak masuk kosong. Belum ada pesan pelanggan.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- JavaScript code -->
    <script>
        // Track the currently active product selected for modal/checkout
        let selectedProductForModal = null;

        // Toggle CMS slide out drawer
        function toggleCmsDrawer() {
            const drawer = document.getElementById('cms-drawer');
            drawer.classList.toggle('active');
        }

        // Switch CMS Drawer Tabs
        function switchCmsTab(tabId) {
            // Remove active class from buttons
            document.querySelectorAll('.cms-tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            // Add active class to clicked button
            const clickedBtn = event.currentTarget;
            if (clickedBtn) clickedBtn.classList.add('active');

            // Hide all tab contents
            document.querySelectorAll('.cms-tab-content').forEach(content => {
                content.classList.remove('active');
            });
            // Show target content
            document.getElementById('tab-' + tabId).classList.add('active');
        }

        // Live text preview in background while typing in CMS settings
        function previewText(elementId, value) {
            const el = document.getElementById(elementId);
            if (el) {
                el.innerText = value;
            }
        }

        // Category Section toggle inside products CMS
        function toggleCategorySection() {
            const container = document.getElementById('cms-category-crud-container');
            if (container.style.display === 'none') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        // Product CRUD Form Visibility
        function showAddProductForm() {
            document.getElementById('cms-product-form-container').style.display = 'block';
            document.getElementById('product-form-title').innerText = 'Tambah Produk Baru';
            document.getElementById('product-form-submit-btn').innerText = 'Simpan Produk';
            document.getElementById('product-crud-form').action = "{{ route('cms.products.store') }}";
            document.getElementById('product-form-method').value = 'POST';
            document.getElementById('cms-inventory-list').style.display = 'none';
            
            // Clear inputs
            document.getElementById('p-name').value = '';
            document.getElementById('p-price').value = '';
            document.getElementById('p-stock').value = '10';
            document.getElementById('p-image-url').value = '';
            document.getElementById('p-image').value = '';
            document.getElementById('p-description').value = '';
        }

        function hideProductForm() {
            document.getElementById('cms-product-form-container').style.display = 'none';
            document.getElementById('cms-inventory-list').style.display = 'block';
        }

        function fillEditProductForm(product) {
            document.getElementById('cms-product-form-container').style.display = 'block';
            document.getElementById('product-form-title').innerText = 'Edit Produk';
            document.getElementById('product-form-submit-btn').innerText = 'Perbarui Produk';
            document.getElementById('product-crud-form').action = `/cms/products/${product.id}`;
            document.getElementById('product-form-method').value = 'POST';
            document.getElementById('cms-inventory-list').style.display = 'none';

            // Fill inputs
            document.getElementById('p-name').value = product.name;
            document.getElementById('p-price').value = Math.round(product.price);
            document.getElementById('p-stock').value = product.stock;
            document.getElementById('p-category-id').value = product.category_id;
            document.getElementById('p-image-url').value = product.image_url || '';
            document.getElementById('p-description').value = product.description || '';
        }

        // Product Details Modal
        function openProductModal(product) {
            selectedProductForModal = product;
            
            document.getElementById('modal-product-title').innerText = product.name;
            document.getElementById('modal-product-category').innerText = product.category ? product.category.name : 'Umum';
            document.getElementById('modal-product-price').innerText = 'Rp ' + Number(product.price).toLocaleString('id-ID');
            document.getElementById('modal-product-desc').innerText = product.description || 'Tidak ada deskripsi.';
            document.getElementById('modal-product-stock').innerText = 'Stok Tersedia: ' + product.stock;
            
            const buyBtn = document.getElementById('buy-now-btn');
            if (product.stock <= 0) {
                buyBtn.innerText = 'Stok Habis';
                buyBtn.disabled = true;
                buyBtn.style.opacity = '0.5';
                buyBtn.style.cursor = 'not-allowed';
            } else {
                buyBtn.innerHTML = '<i class="bx bx-cart-add"></i> Beli Sekarang';
                buyBtn.disabled = false;
                buyBtn.style.opacity = '1';
                buyBtn.style.cursor = 'pointer';
            }

            const img = document.getElementById('modal-product-img');
            img.src = product.image_url;
            img.onerror = function() {
                this.onerror = null;
                this.src = 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=600&auto=format&fit=crop';
            };

            const modal = document.getElementById('product-modal');
            modal.classList.add('active');
        }

        function closeProductModal() {
            const modal = document.getElementById('product-modal');
            modal.classList.remove('active');
        }

        // Checkout Modal Flow
        function openCheckoutModal() {
            if (!selectedProductForModal) return;
            
            // Close product details modal
            closeProductModal();

            // Set checkout modal content
            document.getElementById('checkout-product-id').value = selectedProductForModal.id;
            document.getElementById('checkout-prod-name').innerText = selectedProductForModal.name;
            document.getElementById('checkout-prod-price').innerText = 'Rp ' + Number(selectedProductForModal.price).toLocaleString('id-ID');
            
            // Reset quantity to 1
            const qtyInput = document.getElementById('co-qty');
            qtyInput.value = '1';
            qtyInput.max = selectedProductForModal.stock;
            
            calculateTotalCheckout();

            // Open checkout modal
            const modal = document.getElementById('checkout-modal');
            modal.classList.add('active');
        }

        function closeCheckoutModal() {
            const modal = document.getElementById('checkout-modal');
            modal.classList.remove('active');
        }

        function calculateTotalCheckout() {
            if (!selectedProductForModal) return;
            const qtyInput = document.getElementById('co-qty');
            let qty = parseInt(qtyInput.value) || 1;
            
            // clamp quantity
            if (qty < 1) qty = 1;
            if (qty > selectedProductForModal.stock) qty = selectedProductForModal.stock;
            qtyInput.value = qty;

            const total = selectedProductForModal.price * qty;
            document.getElementById('co-total-display').value = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Close toast alert
        function closeToast() {
            const toast = document.getElementById('toast-message');
            if (toast) {
                toast.style.animation = 'fadeOut 0.4s ease forwards';
                setTimeout(() => toast.remove(), 400);
            }
        }

        // Auto hide toast after 5 seconds
        window.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('toast-message');
            if (toast) {
                setTimeout(() => {
                    closeToast();
                }, 5000);
            }
        });
    </script>
@endsection
