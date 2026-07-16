@extends('layouts.frontend')
@section('title', 'Kontak')

@section('frontend_content')
<!-- Contact Section -->
<section id="contact" class="contact-section" style="padding-top: 120px; min-height: 80vh;">
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
