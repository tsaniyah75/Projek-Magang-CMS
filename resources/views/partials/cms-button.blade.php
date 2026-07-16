<!-- Admin Floating Return Button -->
@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin'))
    <a href="{{ route('home') }}?view=cms" class="floating-cms-btn" title="Kembali ke Dashboard CMS">
        <i class="bx bxs-dashboard"></i> Kembali ke CMS
    </a>
    <style>
        .floating-cms-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary);
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
            z-index: 9999;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .floating-cms-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
            color: white;
        }
        .floating-cms-btn i {
            font-size: 1.2rem;
        }

        /* Live CMS Editor Panel */
        .live-cms-panel {
            position: fixed; top: 0; right: -400px; width: 400px; height: 100vh;
            background: var(--surface); border-left: 1px solid var(--border);
            box-shadow: -5px 0 25px rgba(0,0,0,0.1); z-index: 10000;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column;
        }
        .live-cms-panel.open { right: 0; }
        .live-cms-header {
            padding: 20px; border-bottom: 1px solid var(--border);
            display: flex; justify-content: space-between; align-items: center;
            background: var(--background);
        }
        .live-cms-header h3 { font-size: 1.1rem; margin: 0; display: flex; align-items: center; gap: 8px; color: var(--primary); }
        .live-cms-close { background: transparent; border: none; font-size: 1.5rem; color: var(--text-secondary); cursor: pointer; }
        .live-cms-body { padding: 20px; overflow-y: auto; flex: 1; }
        .live-cms-body .cms-section-title { font-size: 0.9rem; margin-top: 15px; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px dashed var(--border); color: var(--text-secondary); }
        
        /* Override .cms-form for light mode inside the panel */
        .live-cms-panel .cms-form .form-group label { color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; margin-bottom: 6px; }
        .live-cms-panel .cms-form .form-group input, 
        .live-cms-panel .cms-form .form-group textarea,
        .live-cms-panel .cms-form .form-group select {
            background: var(--background);
            border: 1px solid var(--border);
            color: var(--text-primary);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
        }
        .live-cms-panel .cms-form .form-group input:focus, 
        .live-cms-panel .cms-form .form-group textarea:focus,
        .live-cms-panel .cms-form .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        .live-cms-panel .cms-section-title {
            color: var(--primary);
            font-weight: 700;
            border-bottom-color: rgba(0,0,0,0.1);
        }

        .floating-edit-btn {
            position: fixed; bottom: 90px; right: 30px;
            background: var(--surface); color: var(--text-primary);
            border: 1px solid var(--border);
            padding: 12px 20px; border-radius: 50px;
            font-family: 'Outfit', sans-serif; font-weight: 600; font-size: 0.9rem;
            display: flex; align-items: center; gap: 8px; cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); z-index: 9999;
            transition: all 0.2s;
        }
        .floating-edit-btn:hover { background: var(--background); transform: translateY(-3px); }
    </style>

    <button onclick="document.getElementById('live-cms').classList.add('open')" class="floating-edit-btn" title="Buka Live Editor CMS">
        <i class="bx bx-edit"></i> Edit Tampilan Web
    </button>

    <div class="live-cms-panel" id="live-cms">
        <div class="live-cms-header">
            <h3><i class="bx bx-edit-alt"></i> Live CMS Editor</h3>
            <button class="live-cms-close" onclick="document.getElementById('live-cms').classList.remove('open')">&times;</button>
        </div>
        <div class="live-cms-body">
            <p style="font-size:0.85rem; color:var(--text-secondary); margin-bottom:15px;">
                Ubah teks di bawah ini dan lihat perubahannya secara langsung di website.
            </p>
            <form action="{{ route('cms.settings.update') }}" method="POST" enctype="multipart/form-data" class="cms-form" style="gap:10px;">
                @csrf
                <input type="hidden" name="redirect_to" value="website">
                
                <div class="cms-section-title">Informasi Toko</div>
                <div class="form-group">
                    <label>Nama Toko</label>
                    <input type="text" name="shop_name" value="{{ $settings['shop_name'] ?? 'Nia Store' }}" oninput="previewText('logo-text', this.value); previewText('footer-shop-name', this.value);" required>
                </div>

                <div class="cms-section-title">Bagian Hero Banner</div>
                <div class="form-group">
                    <label>Layout Banner</label>
                    <select name="hero_layout" onchange="document.getElementById('hero-container-display').className = 'container hero-container ' + this.value + ' ' + (document.querySelector('[name=hero_image_size]').value === 'wide' ? 'hero-size-wide' : (document.querySelector('[name=hero_image_size]').value === 'full' ? 'hero-size-full' : ''))">
                        <option value="hero-layout-right" {{ ($settings['hero_layout'] ?? '') == 'hero-layout-right' ? 'selected' : '' }}>Gambar di Kanan (Default)</option>
                        <option value="hero-layout-left" {{ ($settings['hero_layout'] ?? '') == 'hero-layout-left' ? 'selected' : '' }}>Gambar di Kiri</option>
                        <option value="hero-layout-top" {{ ($settings['hero_layout'] ?? '') == 'hero-layout-top' ? 'selected' : '' }}>Gambar di Atas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Ukuran Gambar Banner</label>
                    <select name="hero_image_size" onchange="document.getElementById('hero-container-display').className = 'container hero-container ' + document.querySelector('[name=hero_layout]').value + ' ' + (this.value === 'wide' ? 'hero-size-wide' : (this.value === 'full' ? 'hero-size-full' : ''))">
                        <option value="default" {{ ($settings['hero_image_size'] ?? '') == 'default' ? 'selected' : '' }}>Normal (Default)</option>
                        <option value="wide" {{ ($settings['hero_image_size'] ?? '') == 'wide' ? 'selected' : '' }}>Lebar (Wide)</option>
                        <option value="full" {{ ($settings['hero_image_size'] ?? '') == 'full' ? 'selected' : '' }}>Penuh Layar (Full Width)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Gambar Banner (URL / File)</label>
                    <input type="text" name="hero_image_url" value="{{ $settings['hero_image_url'] ?? '' }}" oninput="previewImage('hero-image-display', this.value);" placeholder="URL Gambar..." style="margin-bottom: 8px;">
                    <input type="file" name="hero_image_file" accept="image/*" style="font-size: 0.85rem; padding: 6px;">
                </div>
                <div class="form-group">
                    <label>Judul Banner</label>
                    <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}" oninput="previewText('hero-title-display', this.value);" required>
                </div>
                <div class="form-group">
                    <label>Sub-judul Banner</label>
                    <textarea name="hero_subtitle" rows="3" oninput="previewText('hero-subtitle-display', this.value);" required>{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                </div>

                <div class="cms-section-title">Bagian Tentang Kami</div>
                <div class="form-group">
                    <label>Gambar Tentang Kami (URL / File)</label>
                    <input type="text" name="about_image_url" value="{{ $settings['about_image_url'] ?? '' }}" oninput="previewImage('about-image-display', this.value);" placeholder="URL Gambar..." style="margin-bottom: 8px;">
                    <input type="file" name="about_image_file" accept="image/*" style="font-size: 0.85rem; padding: 6px;">
                </div>
                <div class="form-group">
                    <label>Deskripsi Tentang Kami</label>
                    <textarea name="about_text" rows="4" oninput="previewText('about-text-display', this.value);" required>{{ $settings['about_text'] ?? '' }}</textarea>
                </div>

                <div class="cms-section-title">Informasi Kontak</div>
                <div class="form-group">
                    <label>Email Kontak</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" oninput="previewText('contact-email-display', this.value);" required>
                </div>
                <div class="form-group">
                    <label>No. Telepon / WA</label>
                    <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" oninput="previewText('contact-phone-display', this.value);" required>
                </div>
                <div class="form-group">
                    <label>Alamat Fisik</label>
                    <textarea name="contact_address" rows="2" oninput="previewText('contact-address-display', this.value);" required>{{ $settings['contact_address'] ?? '' }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top:15px; position:sticky; bottom:0;"><i class="bx bx-save"></i> Simpan Pengaturan Web</button>
            </form>

            <hr style="margin: 30px 0; border: none; border-top: 1px dashed var(--border);">
            
            <h4 style="color: var(--primary); margin-bottom: 15px;"><i class="bx bx-box"></i> Kelola Produk (Live)</h4>
            <div class="live-product-list" style="display: flex; flex-direction: column; gap: 10px;">
                @if(isset($products) && count($products) > 0)
                    @foreach($products as $product)
                    <div class="live-product-item glass-card" style="padding: 10px; border-radius: 8px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;" onclick="document.getElementById('edit-prod-{{ $product->id }}').style.display = document.getElementById('edit-prod-{{ $product->id }}').style.display === 'none' ? 'block' : 'none'">
                            <strong style="font-size: 0.9rem;">{{ Str::limit($product->name, 25) }}</strong>
                            <i class="bx bx-edit"></i>
                        </div>
                        <div id="edit-prod-{{ $product->id }}" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px solid var(--border);">
                            <form action="{{ route('cms.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="cms-form">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" name="name" value="{{ $product->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Harga (Rp)</label>
                                    <input type="number" name="price" value="{{ round($product->price) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" name="stock" value="{{ $product->stock }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Gambar Produk (URL / File)</label>
                                    <input type="text" name="image_url" value="{{ $product->image_url }}" placeholder="URL Gambar..." style="margin-bottom: 8px;">
                                    <input type="file" name="image" accept="image/*" style="font-size: 0.85rem; padding: 6px;">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="description" rows="2">{{ $product->description }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-emerald btn-sm btn-block"><i class="bx bx-save"></i> Simpan Produk</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p style="font-size: 0.85rem; color: var(--text-secondary);">Tidak ada produk untuk diedit.</p>
                @endif
            </div>

        </div>
    </div>
@endif
