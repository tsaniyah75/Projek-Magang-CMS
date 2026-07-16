@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- ================================================================ --}}
{{-- ADMIN / SUPER ADMIN LAYOUT: Left Sidebar + Main Content          --}}
{{-- ================================================================ --}}
<div class="admin-layout-wrapper">

    {{-- LEFT SIDEBAR --}}
    <aside class="admin-sidebar" id="admin-sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-logo">
                <i class="bx bxs-shopping-bag"></i>
                <span id="logo-text">{{ $settings['shop_name'] ?? 'Nia Store' }}</span>
            </a>
        </div>

        <div class="sidebar-user-info">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div class="sidebar-user-details">
                <strong>{{ auth()->user()->name }}</strong>
                <span class="role-badge role-badge-{{ auth()->user()->role }}">
                    {{ auth()->user()->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                </span>
            </div>
        </div>

        <hr class="sidebar-divider">

        <nav class="sidebar-nav">
            <a href="#" class="sidebar-nav-item active" onclick="showAdminSection('dashboard'); return false;" id="nav-dashboard">
                <i class="bx bxs-dashboard"></i><span>Dashboard</span>
            </a>
            <a href="#" class="sidebar-nav-item" onclick="showAdminSection('profil'); return false;" id="nav-profil">
                <i class="bx bx-user-circle"></i><span>Profil Saya</span>
            </a>
            <a href="#" class="sidebar-nav-item" onclick="showAdminSection('editor-cms'); return false;" id="nav-editor-cms">
                <i class="bx bx-edit-alt"></i><span>Editor CMS</span>
            </a>
            <a href="#" class="sidebar-nav-item" onclick="showAdminSection('produk'); return false;" id="nav-produk">
                <i class="bx bx-grid-alt"></i><span>Produk &amp; Kategori</span>
            </a>
            <a href="#" class="sidebar-nav-item" onclick="showAdminSection('pesanan'); return false;" id="nav-pesanan">
                <i class="bx bx-list-check"></i>
                <span>Pesanan</span>
                @if($orders->where('status','Baru')->count() > 0)
                    <span class="sidebar-badge">{{ $orders->where('status','Baru')->count() }}</span>
                @endif
            </a>
            @if(auth()->user()->role === 'super_admin')
            <a href="#" class="sidebar-nav-item" onclick="showAdminSection('inbox'); return false;" id="nav-inbox">
                <i class="bx bx-envelope"></i>
                <span>Inbox Pesan</span>
                @if($messages->count() > 0)
                    <span class="sidebar-badge">{{ $messages->count() }}</span>
                @endif
            </a>
            @endif
            <a href="#" class="sidebar-nav-item" onclick="showAdminSection('kelola-user'); return false;" id="nav-kelola-user">
                <i class="bx bx-group"></i><span>Kelola User</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('home') }}?view=website" class="sidebar-nav-item" style="opacity:0.75;">
                <i class="bx bx-globe"></i><span>Lihat Website</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="bx bx-log-out"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="admin-main-content" id="admin-main-content">

        {{-- Top Bar --}}
        <div class="admin-topbar">
            <button class="sidebar-toggle-btn" onclick="toggleAdminSidebar()">
                <i class="bx bx-menu"></i>
            </button>
            <span class="admin-topbar-title" id="admin-section-title">Dashboard</span>
            <div class="admin-topbar-right">
                {{-- Theme Toggle Button --}}
                <button id="theme-toggle-btn" class="theme-toggle-btn" onclick="toggleTheme()" title="Ganti Tema">
                    <i class="bx bx-sun icon-sun"></i>
                    <i class="bx bx-moon icon-moon"></i>
                </button>
                <button onclick="openProfileModal()" class="topbar-profile-btn">
                    <i class="bx bx-user-circle"></i> {{ auth()->user()->name }}
                </button>
            </div>
        </div>


        {{-- Toast Notifications --}}
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
                    @foreach($errors->all() as $error){{ $error }}<br>@endforeach
                </span>
                <button class="toast-close" onclick="closeToast()">&times;</button>
            </div>
        @endif

        {{-- ===== SECTION: DASHBOARD ===== --}}
        <div class="admin-section active" id="admin-section-dashboard">
            <div class="admin-section-header">
                <h1>Dashboard</h1>
                <p>Selamat datang, {{ auth()->user()->name }}! Berikut ringkasan data toko.</p>
            </div>
            <div class="admin-dashboard-stats">
                <div class="admin-stat-card">
                    <div class="stat-icon" style="background:rgba(99,102,241,.12);color:var(--primary);">
                        <i class="bx bx-package"></i>
                    </div>
                    <div class="stat-info"><h3>{{ $products->count() }}</h3><p>Total Produk</p></div>
                </div>
                <div class="admin-stat-card">
                    <div class="stat-icon" style="background:rgba(16,185,129,.12);color:#10b981;">
                        <i class="bx bx-list-check"></i>
                    </div>
                    <div class="stat-info"><h3>{{ $orders->count() }}</h3><p>Total Pesanan</p></div>
                </div>
                <div class="admin-stat-card">
                    <div class="stat-icon" style="background:rgba(245,158,11,.12);color:#f59e0b;">
                        <i class="bx bx-time"></i>
                    </div>
                    <div class="stat-info"><h3>{{ $orders->where('status','Baru')->count() }}</h3><p>Pesanan Baru</p></div>
                </div>
                <div class="admin-stat-card">
                    <div class="stat-icon" style="background:rgba(239,68,68,.12);color:#ef4444;">
                        <i class="bx bx-group"></i>
                    </div>
                    <div class="stat-info"><h3>{{ $users->count() }}</h3><p>Total Pengguna</p></div>
                </div>
            </div>
            <div class="admin-quick-links">
                <p style="color:var(--text-secondary);font-size:.88rem;margin-bottom:14px;">Akses Cepat:</p>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <button onclick="showAdminSection('editor-cms')" class="btn btn-primary btn-sm"><i class="bx bx-edit-alt"></i> Editor CMS</button>
                    <button onclick="showAdminSection('produk')" class="btn btn-outline btn-sm"><i class="bx bx-grid-alt"></i> Produk</button>
                    <button onclick="showAdminSection('pesanan')" class="btn btn-outline btn-sm"><i class="bx bx-list-check"></i> Pesanan</button>
                    <button onclick="showAdminSection('kelola-user')" class="btn btn-outline btn-sm"><i class="bx bx-group"></i> Kelola User</button>
                </div>
            </div>
        </div>

        {{-- ===== SECTION: PROFIL SAYA ===== --}}
        <div class="admin-section" id="admin-section-profil">
            <div class="admin-section-header">
                <h1>Profil Saya</h1>
                <p>Kelola informasi akun dan password Anda.</p>
            </div>
            <div class="admin-card" style="max-width:560px;">
                <form action="{{ route('profile.update') }}" method="POST" class="cms-form">
                    @csrf
                    <div class="form-group">
                        <label for="prof-name">Nama Lengkap</label>
                        <input type="text" name="name" id="prof-name" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="prof-email">Alamat Email</label>
                        <input type="email" name="email" id="prof-email" value="{{ auth()->user()->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="prof-current-password">Password Saat Ini (Wajib untuk verifikasi)</label>
                        <input type="password" name="current_password" id="prof-current-password" required placeholder="Masukkan password saat ini...">
                    </div>
                    <hr style="border:0;border-top:1px solid var(--border);margin:20px 0;">
                    <div class="form-group">
                        <label for="prof-new-password">Password Baru (Kosongkan jika tidak ingin diubah)</label>
                        <input type="password" name="new_password" id="prof-new-password" placeholder="Masukkan password baru...">
                    </div>
                    <div class="form-group">
                        <label for="prof-new-password-confirm">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" id="prof-new-password-confirm" placeholder="Ulangi password baru...">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top:16px;">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        {{-- ===== SECTION: EDITOR CMS ===== --}}
        <div class="admin-section" id="admin-section-editor-cms">
            <div class="admin-section-header">
                <h1>Editor CMS</h1>
                <p>Edit tampilan dan konten website secara langsung.</p>
            </div>
            <div class="admin-card">
                <form action="{{ route('cms.settings.update') }}" method="POST" enctype="multipart/form-data" class="cms-form" style="gap:15px;">
                    @csrf
                    <div class="cms-section-title">Informasi Toko</div>
                    <div class="form-group">
                        <label for="input-shop_name">Nama Toko</label>
                        <input type="text" name="shop_name" id="input-shop_name" value="{{ $settings['shop_name'] ?? 'Nia Store' }}" oninput="previewText('logo-text', this.value); previewText('footer-shop-name', this.value);" required>
                    </div>

                    <div class="cms-section-title">Bagian Hero Banner</div>
                    <div class="form-group">
                        <label for="input-hero_layout">Layout Banner</label>
                        <select name="hero_layout" id="input-hero_layout" onchange="document.getElementById('hero-container-display').className = 'container hero-container ' + this.value + ' ' + (document.getElementById('input-hero_image_size').value === 'wide' ? 'hero-size-wide' : (document.getElementById('input-hero_image_size').value === 'full' ? 'hero-size-full' : ''))">
                            <option value="hero-layout-right" {{ ($settings['hero_layout'] ?? '') == 'hero-layout-right' ? 'selected' : '' }}>Gambar di Kanan (Default)</option>
                            <option value="hero-layout-left" {{ ($settings['hero_layout'] ?? '') == 'hero-layout-left' ? 'selected' : '' }}>Gambar di Kiri</option>
                            <option value="hero-layout-top" {{ ($settings['hero_layout'] ?? '') == 'hero-layout-top' ? 'selected' : '' }}>Gambar di Atas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-hero_image_size">Ukuran Gambar Banner</label>
                        <select name="hero_image_size" id="input-hero_image_size" onchange="document.getElementById('hero-container-display').className = 'container hero-container ' + document.getElementById('input-hero_layout').value + ' ' + (this.value === 'wide' ? 'hero-size-wide' : (this.value === 'full' ? 'hero-size-full' : ''))">
                            <option value="default" {{ ($settings['hero_image_size'] ?? '') == 'default' ? 'selected' : '' }}>Normal (Default)</option>
                            <option value="wide" {{ ($settings['hero_image_size'] ?? '') == 'wide' ? 'selected' : '' }}>Lebar (Wide)</option>
                            <option value="full" {{ ($settings['hero_image_size'] ?? '') == 'full' ? 'selected' : '' }}>Penuh Layar (Full Width)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-hero_image_url">Gambar Banner Utama (URL / File)</label>
                        <input type="text" name="hero_image_url" id="input-hero_image_url" value="{{ $settings['hero_image_url'] ?? '' }}" oninput="previewImage('hero-image-display', this.value);" placeholder="URL Gambar..." style="margin-bottom: 8px;">
                        <input type="file" name="hero_image_file" id="input-hero_image_file" accept="image/*" style="padding: 6px;">
                    </div>
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
                        <label for="input-about_image_url">Gambar Tentang Kami (URL / File)</label>
                        <input type="text" name="about_image_url" id="input-about_image_url" value="{{ $settings['about_image_url'] ?? '' }}" oninput="previewImage('about-image-display', this.value);" placeholder="URL Gambar..." style="margin-bottom: 8px;">
                        <input type="file" name="about_image_file" id="input-about_image_file" accept="image/*" style="padding: 6px;">
                    </div>
                    <div class="form-group">
                        <label for="input-about_text">Deskripsi Tentang Kami</label>
                        <textarea name="about_text" id="input-about_text" rows="4" oninput="previewText('about-text-display', this.value);" required>{{ $settings['about_text'] ?? '' }}</textarea>
                    </div>

                    <div class="cms-section-title">Informasi Kontak &amp; Footer</div>
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

                    <button type="submit" class="btn btn-primary btn-block"><i class="bx bx-save"></i> Simpan Perubahan Web</button>
                </form>
            </div>
        </div>

        {{-- ===== SECTION: PRODUK & KATEGORI ===== --}}
        <div class="admin-section" id="admin-section-produk">
            <div class="admin-section-header">
                <h1>Produk &amp; Kategori</h1>
                <p>Kelola produk dan kategori yang tampil di website.</p>
            </div>
            <div class="admin-card">
                <div class="cms-actions-bar" style="display:flex;gap:10px;margin-bottom:16px;">
                    <button class="btn btn-emerald btn-sm" onclick="showAddProductForm()">
                        <i class="bx bx-plus"></i> Tambah Produk
                    </button>
                    <button class="btn btn-outline btn-sm" onclick="toggleCategorySection()">
                        <i class="bx bx-category"></i> Kelola Kategori
                    </button>
                </div>

                {{-- Categories CRUD --}}
                <div class="cms-product-form-container" id="cms-category-crud-container" style="display:none;margin-bottom:20px;">
                    <div class="cms-form-sub-header">
                        <h4>Kelola Kategori Database</h4>
                        <button class="btn-text-close" onclick="toggleCategorySection()">&times; Tutup</button>
                    </div>
                    <form action="{{ route('cms.categories.store') }}" method="POST" class="cms-form" style="margin-bottom:20px;">
                        @csrf
                        <div class="form-group" style="display:flex;gap:10px;margin-bottom:0;">
                            <input type="text" name="name" placeholder="Nama kategori baru..." required style="flex:1;">
                            <button type="submit" class="btn btn-emerald btn-sm" style="padding:10px 15px;">Tambah</button>
                        </div>
                    </form>
                    <div class="cms-category-list-sub">
                        @foreach($categories as $cat)
                            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:var(--background);border-radius:6px;margin-bottom:6px;border:1px solid var(--border);">
                                <span>{{ $cat->name }} ({{ $cat->products->count() }} produk)</span>
                                @if($cat->id != 4)
                                    <form action="{{ route('cms.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Menghapus kategori juga akan menghapus produk di dalamnya. Hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:transparent;border:none;color:var(--danger);cursor:pointer;"><i class="bx bx-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Product Add / Edit Form --}}
                <div class="cms-product-form-container" id="cms-product-form-container" style="display:none;">
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

                {{-- Product Inventory List --}}
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
        </div>

        {{-- ===== SECTION: PESANAN ===== --}}
        <div class="admin-section" id="admin-section-pesanan">
            <div class="admin-section-header">
                <h1>Pesanan Masuk</h1>
                <p>Pantau dan perbarui status pesanan pelanggan.</p>
            </div>
            <div class="admin-card">
                <div class="cms-section-title">Transaksi Penjualan Pelanggan</div>
                @forelse($orders as $order)
                    <div class="cms-order-card">
                        <div class="cms-order-card-header">
                            <div>
                                <strong>#{{ $order->id }} - {{ $order->customer_name }}</strong>
                                <span class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
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
                            <div class="order-info-address"><strong>Alamat:</strong> {{ $order->customer_address }}</div>
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
        </div>

        {{-- ===== SECTION: INBOX (Super Admin only) ===== --}}
        @if(auth()->user()->role === 'super_admin')
        <div class="admin-section" id="admin-section-inbox">
            <div class="admin-section-header">
                <h1>Inbox Pesan</h1>
                <p>Pesan dari pelanggan melalui formulir Kontak.</p>
            </div>
            <div class="admin-card">
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
        @endif

        {{-- ===== SECTION: KELOLA USER ===== --}}
        <div class="admin-section" id="admin-section-kelola-user">
            <div class="admin-section-header">
                <h1>Kelola Pengguna</h1>
                <p>Tambah, edit, dan hapus akun pengguna.</p>
            </div>
            <div class="admin-card">
                <div class="cms-actions-bar" style="margin-bottom:20px;">
                    <button class="btn btn-emerald btn-sm" onclick="showAddUserForm()">
                        <i class="bx bx-user-plus"></i> Tambah Pengguna
                    </button>
                </div>

                {{-- User Add/Edit Form --}}
                <div class="cms-product-form-container" id="cms-user-form-container" style="display:none;margin-bottom:20px;">
                    <div class="cms-form-sub-header">
                        <h4 id="user-form-title">Tambah Pengguna Baru</h4>
                        <button class="btn-text-close" onclick="hideUserForm()">&times; Batal</button>
                    </div>
                    <form id="user-crud-form" action="{{ route('cms.users.store') }}" method="POST" class="cms-form">
                        @csrf
                        <div class="form-group">
                            <label for="u-name">Nama Lengkap</label>
                            <input type="text" name="name" id="u-name" required placeholder="Masukkan nama...">
                        </div>
                        <div class="form-group">
                            <label for="u-email">Email</label>
                            <input type="email" name="email" id="u-email" required placeholder="email@niastore.com">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="u-password">Password</label>
                                <input type="password" name="password" id="u-password" required placeholder="Min. 6 karakter...">
                            </div>
                            <div class="form-group">
                                <label for="u-role">Role Akses</label>
                                <select name="role" id="u-role" required>
                                    <option value="user">User (Customer)</option>
                                    @if(auth()->user()->role === 'super_admin')
                                        <option value="admin">Admin</option>
                                        <option value="super_admin">Super Admin</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" id="user-form-submit-btn">Simpan Pengguna</button>
                    </form>
                </div>

                {{-- User List --}}
                <div class="cms-section-title">Daftar Pengguna</div>
                @foreach($users as $user)
                    <div class="cms-user-item">
                        <div class="cms-user-item-info">
                            <div class="cms-user-avatar-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                            <div>
                                <strong>{{ $user->name }}</strong>
                                <span>{{ $user->email }} &nbsp;|&nbsp;
                                    <span class="role-badge role-badge-{{ $user->role }}" style="font-size:.65rem;">
                                        {{ $user->role === 'super_admin' ? 'Super Admin' : ($user->role === 'admin' ? 'Admin' : 'User') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="cms-user-actions">
                            <form action="{{ route('cms.users.updateRole', $user->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <select name="role" class="role-select-inline" onchange="this.form.submit()" {{ auth()->user()->role !== 'super_admin' ? 'disabled' : '' }}>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                </select>
                            </form>
                            <button type="button" class="btn btn-primary btn-icon-sm"
                                data-user-id="{{ $user->id }}"
                                data-user-name="{{ $user->name }}"
                                data-user-email="{{ $user->email }}"
                                data-user-role="{{ $user->role }}"
                                onclick="showEditUserForm(this)" title="Edit Pengguna"
                                style="padding:6px;height:32px;width:32px;border-radius:4px;border:none;cursor:pointer;background:var(--primary);color:white;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="bx bx-edit"></i>
                            </button>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('cms.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon-sm" title="Hapus Pengguna" style="padding:6px;height:32px;width:32px;border-radius:4px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
                @if($users->isEmpty())
                    <p class="empty-text">Tidak ada pengguna yang dapat dikelola.</p>
                @endif
            </div>
        </div>

    </main>{{-- end .admin-main-content --}}
</div>{{-- end .admin-layout-wrapper --}}

{{-- Profile Modal (juga tersedia untuk admin) --}}
<div class="modal-overlay" id="profile-modal">
    <div class="modal-card modal-card-sm">
        <button class="modal-close" onclick="closeProfileModal()">&times;</button>
        <div class="modal-details">
            <span class="modal-category">Pengaturan Akun</span>
            <h2 style="font-size:1.5rem;margin-bottom:20px;">Kelola Profil Anda</h2>
            <form action="{{ route('profile.update') }}" method="POST" class="cms-form">
                @csrf
                <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" value="{{ auth()->user()->name }}" required></div>
                <div class="form-group"><label>Alamat Email</label><input type="email" name="email" value="{{ auth()->user()->email }}" required></div>
                <div class="form-group"><label>Password Saat Ini (Wajib)</label><input type="password" name="current_password" required placeholder="Password saat ini..."></div>
                <hr style="border:0;border-top:1px dashed rgba(128,128,128,.2);margin:16px 0;">
                <div class="form-group"><label>Password Baru (Opsional)</label><input type="password" name="new_password" placeholder="Password baru..."></div>
                <div class="form-group"><label>Konfirmasi Password Baru</label><input type="password" name="new_password_confirmation" placeholder="Ulangi password baru..."></div>
                <div class="modal-actions" style="margin-top:16px;">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('partials.scripts')
@endsection
