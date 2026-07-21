<!-- Footer -->
<footer class="footer">
    <div class="container footer-container">
        <div class="footer-brand">
            <a href="{{ route('home') }}" class="logo">
                <i class="bx bxs-shopping-bag logo-icon"></i>
                <span>{{ $settings['shop_name'] ?? 'Sepatuku.id' }}</span>
            </a>
            <p>Destinasi belanja sepatu online terlengkap & terpercaya. Ribuan model sepatu, 100% original, pengiriman kilat ke seluruh Indonesia.</p>
            <div class="social-links">
                <a href="#"><i class="bx bxl-facebook"></i></a>
                <a href="#"><i class="bx bxl-instagram"></i></a>
                <a href="#"><i class="bx bxl-twitter"></i></a>
                <a href="#"><i class="bx bxl-linkedin"></i></a>
            </div>
        </div>
        <div class="footer-links">
            <h4>Navigasi</h4>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('products') }}">Katalog Produk</a>
            <a href="{{ route('about') }}">Tentang Kami</a>
            <a href="{{ route('contact.page') }}">Hubungi Kami</a>
        </div>
        <div class="footer-links">
            <h4>Kategori</h4>
            @foreach(App\Models\Category::take(4)->get() as $cat)
                <a href="{{ route('products', ['category' => $cat->slug]) }}">{{ $cat->name }}</a>
            @endforeach
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 <span id="footer-shop-name">{{ $settings['shop_name'] ?? 'Nia Store' }}</span>. Hak Cipta Dilindungi Undang-Undang.</p>
    </div>
</footer>
