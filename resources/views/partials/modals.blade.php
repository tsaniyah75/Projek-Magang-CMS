<!-- PRODUCT DETAIL MODAL -->
<div class="modal-overlay" id="product-modal">
    <div class="modal-card">
        <button class="modal-close" onclick="closeProductModal()">&times;</button>
        <div class="modal-grid">
            <div class="modal-img-container"><img id="modal-product-img" src="" alt=""></div>
            <div class="modal-details">
                <span class="modal-category" id="modal-product-category">Kategori</span>
                <h2 id="modal-product-title">Nama Produk</h2>
                <span class="modal-price" id="modal-product-price">Rp 0</span>
                <p class="modal-description" id="modal-product-desc">Deskripsi lengkap produk.</p>
                <div class="modal-meta"><span class="stock-indicator" id="modal-product-stock">Stok Tersedia: 0</span></div>
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
            <h2 style="font-size:1.5rem;margin-bottom:8px;">Checkout: <span id="checkout-prod-name">Produk</span></h2>
            <span class="modal-price" id="checkout-prod-price" style="font-size:1.25rem;margin-bottom:20px;">Rp 0</span>
            <form action="{{ route('checkout.process') }}" method="POST" class="cms-form">
                @csrf
                <input type="hidden" name="product_id" id="checkout-product-id">
                <div class="form-row">
                    <div class="form-group"><label for="co-qty">Kuantitas / Jumlah</label><input type="number" name="quantity" id="co-qty" value="1" min="1" oninput="calculateTotalCheckout()" required></div>
                    <div class="form-group"><label>Total Bayar</label><input type="text" id="co-total-display" value="Rp 0" readonly style="font-weight:700;color:var(--primary);background:#f1f5f9;"></div>
                </div>
                <div class="form-group"><label for="co-name">Nama Penerima</label><input type="text" name="customer_name" id="co-name" placeholder="Nama lengkap Anda..." required></div>
                <div class="form-row">
                    <div class="form-group"><label for="co-email">Email</label><input type="email" name="customer_email" id="co-email" placeholder="email@domain.com" required></div>
                    <div class="form-group"><label for="co-phone">No. Handphone / WA</label><input type="text" name="customer_phone" id="co-phone" placeholder="Contoh: 0812..." required></div>
                </div>
                <div class="form-group"><label for="co-address">Alamat Lengkap Pengiriman</label><textarea name="customer_address" id="co-address" rows="3" placeholder="Masukkan alamat lengkap rumah Anda..." required></textarea></div>
                <div class="modal-actions" style="margin-top:10px;">
                    <button type="submit" class="btn btn-primary btn-block">Konfirmasi &amp; Pesan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

@auth
<!-- PROFILE MODAL -->
<div class="modal-overlay" id="profile-modal">
    <div class="modal-card modal-card-sm">
        <button class="modal-close" onclick="closeProfileModal()">&times;</button>
        <div class="modal-details">
            <span class="modal-category">Pengaturan Akun</span>
            <h2 style="font-size:1.5rem;margin-bottom:20px;">Kelola Profil Anda</h2>
            <form action="{{ route('profile.update') }}" method="POST" class="cms-form">
                @csrf
                <div class="form-group"><label for="prof-name">Nama Lengkap</label><input type="text" name="name" id="prof-name" value="{{ auth()->user()->name }}" required placeholder="Nama lengkap..."></div>
                <div class="form-group"><label for="prof-email">Alamat Email</label><input type="email" name="email" id="prof-email" value="{{ auth()->user()->email }}" required placeholder="email@domain.com"></div>
                <div class="form-group"><label for="prof-current-password">Password Saat Ini (Wajib)</label><input type="password" name="current_password" id="prof-current-password" required placeholder="Masukkan password saat ini..."></div>
                <hr style="border:0;border-top:1px dashed rgba(128,128,128,.2);margin:20px 0;">
                <div class="form-group"><label for="prof-new-password">Password Baru (Opsional)</label><input type="password" name="new_password" id="prof-new-password" placeholder="Masukkan password baru..."></div>
                <div class="form-group"><label for="prof-new-password-confirm">Konfirmasi Password Baru</label><input type="password" name="new_password_confirmation" id="prof-new-password-confirm" placeholder="Ulangi password baru..."></div>
                <div class="modal-actions" style="margin-top:20px;">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth
