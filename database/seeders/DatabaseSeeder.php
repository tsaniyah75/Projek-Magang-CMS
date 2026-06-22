<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add default admin
        User::factory()->create([
            'name' => 'Admin Nia',
            'email' => 'admin@niastore.com',
            'password' => bcrypt('password'),
        ]);

        // Add site settings
        $settings = [
            'shop_name' => 'Nia Store',
            'hero_title' => 'Gaya Hidup Modern dengan Produk Berkualitas',
            'hero_subtitle' => 'Temukan berbagai macam produk kebutuhan harian, teknologi terbaru, dan aksesoris rumah berkualitas tinggi dengan harga terbaik.',
            'contact_email' => 'info@niastore.com',
            'contact_phone' => '+62 812-3456-7890',
            'contact_address' => 'Jl. Merdeka No. 45, Jakarta Pusat, Indonesia',
            'about_text' => 'Nia Store adalah platform e-commerce pilihan yang menyediakan produk-produk kurasi terbaik. Komitmen kami adalah memberikan pengalaman berbelanja yang mudah, cepat, dan aman serta kualitas produk yang selalu terjaga.',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::setValue($key, $value);
        }

        // Add default categories
        $catTeknologi = Category::create(['name' => 'Teknologi']);
        $catAksesoris = Category::create(['name' => 'Aksesoris']);
        $catRumahTangga = Category::create(['name' => 'Rumah Tangga']);
        $catUmum = Category::create(['name' => 'Umum']);

        // Add products linked to categories
        $p1 = Product::create([
            'category_id' => $catTeknologi->id,
            'name' => 'Premium Smart Watch v2',
            'description' => 'Jam tangan pintar dengan layar AMOLED 1.43 inci, pemantau kesehatan 24 jam, pelacakan GPS, dan daya tahan baterai hingga 14 hari. Tahan air hingga kedalaman 50 meter.',
            'price' => 2499000.00,
            'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop',
            'stock' => 15,
        ]);

        $p2 = Product::create([
            'category_id' => $catTeknologi->id,
            'name' => 'Wireless Noise Cancelling Headphones',
            'description' => 'Headphone nirkabel dengan Active Noise Cancelling premium, suara berkualitas resolusi tinggi, kontrol sentuh pintar, dan daya tahan baterai hingga 30 jam dengan pengisian cepat.',
            'price' => 3899000.00,
            'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=600&auto=format&fit=crop',
            'stock' => 8,
        ]);

        $p3 = Product::create([
            'category_id' => $catAksesoris->id,
            'name' => 'Retro Mechanical Keyboard (Brown Switch)',
            'description' => 'Keyboard mekanik dengan tata letak 75%, konektivitas tiga mode (Bluetooth, 2.4Ghz, Kabel), tombol hotswappable, dan lampu latar RGB dinamis dengan switch Brown yang taktil.',
            'price' => 1250000.00,
            'image_url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?q=80&w=600&auto=format&fit=crop',
            'stock' => 25,
        ]);

        $p4 = Product::create([
            'category_id' => $catRumahTangga->id,
            'name' => 'Minimalist Drip Coffee Maker',
            'description' => 'Mesin pembuat kopi tetes otomatis dengan desain estetik minimalis. Kapasitas 1.25 liter, dilengkapi dengan sistem pemanas instan dan pelat penghangat otomatis.',
            'price' => 899000.00,
            'image_url' => 'https://images.unsplash.com/photo-1517256064527-09c53b2d0bc6?q=80&w=600&auto=format&fit=crop',
            'stock' => 12,
        ]);

        $p5 = Product::create([
            'category_id' => $catRumahTangga->id,
            'name' => 'Ergonomic Desk LED Lamp',
            'description' => 'Lampu meja LED hemat energi dengan 5 tingkat kecerahan, kontrol temperatur warna (dingin ke hangat), port pengisian daya USB, dan lengan yang dapat disesuaikan.',
            'price' => 450000.00,
            'image_url' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?q=80&w=600&auto=format&fit=crop',
            'stock' => 20,
        ]);

        $p6 = Product::create([
            'category_id' => $catAksesoris->id,
            'name' => 'Urban Commuter Backpack',
            'description' => 'Tas punggung komuter perkotaan tahan air dengan slot laptop khusus hingga 15.6 inci, banyak saku organizer tersembunyi, dan panel belakang dengan sirkulasi udara yang nyaman.',
            'price' => 750000.00,
            'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=600&auto=format&fit=crop',
            'stock' => 18,
        ]);

        // Add dummy transactions (Orders)
        $o1 = Order::create([
            'customer_name' => 'Rian Hidayat',
            'customer_email' => 'rian@gmail.com',
            'customer_phone' => '081298765432',
            'customer_address' => 'Perumahan Indah Permai Blok C3 No. 12, Bekasi',
            'total_price' => 2499000.00,
            'status' => 'Dibayar',
        ]);
        OrderItem::create([
            'order_id' => $o1->id,
            'product_id' => $p1->id,
            'quantity' => 1,
            'price' => $p1->price,
        ]);

        $o2 = Order::create([
            'customer_name' => 'Siti Aminah',
            'customer_email' => 'siti@yahoo.com',
            'customer_phone' => '085712345678',
            'customer_address' => 'Jl. Kebon Jeruk No. 8, Jakarta Barat',
            'total_price' => 900000.00,
            'status' => 'Baru',
        ]);
        OrderItem::create([
            'order_id' => $o2->id,
            'product_id' => $p5->id,
            'quantity' => 2,
            'price' => $p5->price,
        ]);

        // Add dummy messages
        ContactMessage::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@corp.id',
            'message' => 'Apakah produk Smart Watch v2 memiliki pilihan warna tali selain hitam? Terima kasih.',
        ]);
        ContactMessage::create([
            'name' => 'Elena Wijaya',
            'email' => 'elena@live.com',
            'message' => 'Situs webnya sangat indah dan mudah digunakan! Apakah Nia Store menerima metode pembayaran COD?',
        ]);
    }
}
