<script>
    let selectedProductForModal = null;

    // ---- ADMIN SIDEBAR ----
    function showAdminSection(sectionId) {
        document.querySelectorAll('.admin-section').forEach(s => s.classList.remove('active'));
        const target = document.getElementById('admin-section-' + sectionId);
        if (target) target.classList.add('active');

        document.querySelectorAll('.sidebar-nav-item').forEach(item => item.classList.remove('active'));
        const navKey = sectionId === 'editor-cms' ? 'editor-cms' : sectionId;
        const navItem = document.getElementById('nav-' + navKey);
        if (navItem) navItem.classList.add('active');

        const titles = {
            'dashboard': 'Dashboard', 'profil': 'Profil Saya',
            'editor-cms': 'Editor CMS', 'produk': 'Produk & Kategori',
            'pesanan': 'Pesanan Masuk', 'inbox': 'Inbox Pesan',
            'kelola-user': 'Kelola Pengguna'
        };
        const titleEl = document.getElementById('admin-section-title');
        if (titleEl) titleEl.textContent = titles[sectionId] || sectionId;

        if (window.innerWidth < 768) {
            document.getElementById('admin-sidebar').classList.remove('sidebar-open');
        }
    }

    function toggleAdminSidebar() {
        const s = document.getElementById('admin-sidebar');
        if (s) s.classList.toggle('sidebar-open');
    }

    // ---- CMS HELPERS ----
    function previewText(elementId, value) {
        const el = document.getElementById(elementId);
        if (el) el.innerText = value;
    }

    function previewImage(elementId, value) {
        const el = document.getElementById(elementId);
        if (el) el.src = value;
    }

    function toggleCategorySection() {
        const c = document.getElementById('cms-category-crud-container');
        if (c) c.style.display = c.style.display === 'none' ? 'block' : 'none';
    }

    // ---- PRODUCT CRUD ----
    function showAddProductForm() {
        document.getElementById('cms-product-form-container').style.display = 'block';
        document.getElementById('product-form-title').innerText = 'Tambah Produk Baru';
        document.getElementById('product-form-submit-btn').innerText = 'Simpan Produk';
        document.getElementById('product-crud-form').action = "{{ route('cms.products.store') }}";
        document.getElementById('product-form-method').value = 'POST';
        document.getElementById('cms-inventory-list').style.display = 'none';
        document.getElementById('p-name').value = '';
        document.getElementById('p-price').value = '';
        document.getElementById('p-stock').value = '10';
        document.getElementById('p-image-url').value = '';
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
        document.getElementById('p-name').value = product.name;
        document.getElementById('p-price').value = Math.round(product.price);
        document.getElementById('p-stock').value = product.stock;
        document.getElementById('p-category-id').value = product.category_id;
        document.getElementById('p-image-url').value = product.image_url || '';
        document.getElementById('p-description').value = product.description || '';
    }

    // ---- USER CRUD ----
    function showAddUserForm() {
        document.getElementById('cms-user-form-container').style.display = 'block';
        document.getElementById('user-form-title').innerText = 'Tambah Pengguna Baru';
        document.getElementById('user-form-submit-btn').innerText = 'Simpan Pengguna';
        document.getElementById('user-crud-form').action = "{{ route('cms.users.store') }}";
        const pwd = document.getElementById('u-password');
        pwd.required = true;
        pwd.placeholder = 'Min. 6 karakter...';
        document.getElementById('u-name').value = '';
        document.getElementById('u-email').value = '';
        document.getElementById('u-password').value = '';
        document.getElementById('u-role').value = 'user';
    }

    function showEditUserForm(btn) {
        document.getElementById('cms-user-form-container').style.display = 'block';
        document.getElementById('user-form-title').innerText = 'Edit Pengguna';
        document.getElementById('user-form-submit-btn').innerText = 'Perbarui Pengguna';
        const userId = btn.getAttribute('data-user-id');
        document.getElementById('user-crud-form').action = `/cms/users/${userId}`;
        const pwd = document.getElementById('u-password');
        pwd.required = false;
        pwd.placeholder = 'Kosongkan jika tidak ingin diubah';
        document.getElementById('u-name').value = btn.getAttribute('data-user-name');
        document.getElementById('u-email').value = btn.getAttribute('data-user-email');
        document.getElementById('u-password').value = '';
        document.getElementById('u-role').value = btn.getAttribute('data-user-role');
    }

    function hideUserForm() {
        document.getElementById('cms-user-form-container').style.display = 'none';
    }

    // ---- PRODUCT MODAL ----
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
            buyBtn.disabled = true; buyBtn.style.opacity = '0.5'; buyBtn.style.cursor = 'not-allowed';
        } else {
            buyBtn.innerHTML = '<i class="bx bx-cart-add"></i> Beli Sekarang';
            buyBtn.disabled = false; buyBtn.style.opacity = '1'; buyBtn.style.cursor = 'pointer';
        }
        const img = document.getElementById('modal-product-img');
        img.src = product.image_url;
        img.onerror = function() { this.onerror=null; this.src='https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=600&auto=format&fit=crop'; };
        document.getElementById('product-modal').classList.add('active');
    }

    function closeProductModal() { document.getElementById('product-modal').classList.remove('active'); }

    // ---- CHECKOUT MODAL ----
    function openCheckoutModal() {
        if (!selectedProductForModal) return;
        closeProductModal();
        document.getElementById('checkout-product-id').value = selectedProductForModal.id;
        document.getElementById('checkout-prod-name').innerText = selectedProductForModal.name;
        document.getElementById('checkout-prod-price').innerText = 'Rp ' + Number(selectedProductForModal.price).toLocaleString('id-ID');
        const qtyInput = document.getElementById('co-qty');
        qtyInput.value = '1'; qtyInput.max = selectedProductForModal.stock;
        calculateTotalCheckout();
        document.getElementById('checkout-modal').classList.add('active');
    }

    function closeCheckoutModal() { document.getElementById('checkout-modal').classList.remove('active'); }

    function calculateTotalCheckout() {
        if (!selectedProductForModal) return;
        const qtyInput = document.getElementById('co-qty');
        let qty = parseInt(qtyInput.value) || 1;
        if (qty < 1) qty = 1;
        if (qty > selectedProductForModal.stock) qty = selectedProductForModal.stock;
        qtyInput.value = qty;
        document.getElementById('co-total-display').value = 'Rp ' + (selectedProductForModal.price * qty).toLocaleString('id-ID');
    }

    // ---- PROFILE MODAL ----
    function openProfileModal() { const m = document.getElementById('profile-modal'); if (m) m.classList.add('active'); }
    function closeProfileModal() { const m = document.getElementById('profile-modal'); if (m) m.classList.remove('active'); }

    // ---- TOAST ----
    function closeToast() {
        const t = document.getElementById('toast-message');
        if (t) { t.style.animation = 'fadeOut 0.4s ease forwards'; setTimeout(() => t.remove(), 400); }
    }

    // ---- THEME TOGGLE ----
    function getStoredTheme() {
        return localStorage.getItem('nia-theme');
    }

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.removeAttribute('data-theme');
        }
    }

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme');
        const next = (current === 'dark') ? 'light' : 'dark';
        applyTheme(next);
        localStorage.setItem('nia-theme', next);
    }

    // Apply saved theme or fall back to system preference on load
    (function initTheme() {
        const saved = getStoredTheme();
        if (saved) {
            applyTheme(saved);
        } else {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            applyTheme(prefersDark ? 'dark' : 'light');
        }
    })();

    // ---- INIT ----
    window.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast-message');
        if (toast) setTimeout(() => closeToast(), 5000);
    });
</script>
