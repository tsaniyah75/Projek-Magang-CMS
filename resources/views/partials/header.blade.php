<!-- Navigation Bar -->
<header class="header">
    <div class="container nav-container">
        <a href="{{ route('home') }}" class="logo">
            <i class="bx bxs-shopping-bag logo-icon"></i>
            <span id="logo-text">{{ $settings['shop_name'] ?? 'Nia Store' }}</span>
        </a>

        <nav class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('products') }}" class="{{ request()->routeIs('products') ? 'active' : '' }}">Produk</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a>
            <a href="{{ route('contact.page') }}" class="{{ request()->routeIs('contact.page') ? 'active' : '' }}">Kontak</a>
        </nav>

        <div class="nav-actions" style="display:flex;gap:15px;align-items:center;">

            {{-- Theme Toggle Button --}}
            <button class="theme-toggle-btn" onclick="toggleTheme()" title="Ganti Tema Gelap/Terang">
                <i class="bx bx-sun icon-sun"></i>
                <i class="bx bx-moon icon-moon"></i>
            </button>

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="padding:10px 20px;">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm" style="padding:10px 20px;box-shadow:none;">Daftar</a>
            @else
                <button class="btn btn-outline btn-sm" onclick="openProfileModal()"
                    style="padding:10px 15px;font-size:.85rem;display:inline-flex;align-items:center;gap:4px;cursor:pointer;border-radius:6px;">
                    <i class="bx bx-user"></i> Kelola Profil
                </button>
                <div style="display:flex;align-items:center;gap:8px;">
                    <i class="bx bx-user-circle" style="font-size:1.6rem;color:var(--primary);"></i>
                    <span style="font-weight:600;font-size:.95rem;color:var(--text-primary);">
                        {{ auth()->user()->name }}
                        <span class="role-badge role-badge-user" style="font-size:.65rem;margin-left:4px;">User</span>
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm"
                        style="padding:6px 12px;font-size:.8rem;border-color:var(--danger);color:var(--danger);background:transparent;"
                        onmouseover="this.style.background='var(--danger)';this.style.color='white';"
                        onmouseout="this.style.background='transparent';this.style.color='var(--danger)';">
                        <i class="bx bx-log-out"></i> Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</header>

