@extends('layouts.frontend')
@section('title', 'Katalog Produk')

@section('frontend_content')
<!-- Products Catalog Section -->
<section id="products" class="products-section" style="padding-top: 120px;">
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
@endsection
