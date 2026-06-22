<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display the store home page.
     */
    public function index(Request $request)
    {
        // Get all site settings as a key-value array
        $settings = SiteSetting::pluck('value', 'key')->all();

        // Query products with category preloaded
        $query = Product::with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->latest()->get();

        // Get all categories for filter tabs and forms
        $categories = Category::all();

        // Get additional CMS data for rendering inside the CMS panel
        $orders = Order::with('items.product')->latest()->get();
        $messages = ContactMessage::latest()->get();

        return view('index', compact('products', 'settings', 'categories', 'orders', 'messages'));
    }

    /**
     * Submit a contact message.
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return redirect()->to(route('home') . '#contact')
                         ->with('success', 'Pesan Anda berhasil terkirim dan disimpan di database Nia Store!');
    }

    /**
     * Process checkout/purchase from client side.
     */
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_address' => 'required|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $qty = intval($validated['quantity']);

        // Check stock
        if ($product->stock < $qty) {
            return redirect()->back()->withErrors(['quantity' => 'Stok produk tidak mencukupi untuk pembelian ini.']);
        }

        // DB Transaction for safety
        DB::transaction(function() use ($product, $qty, $validated) {
            // Deduct stock
            $product->decrement('stock', $qty);

            $totalPrice = $product->price * $qty;

            // Create Order
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'total_price' => $totalPrice,
                'status' => 'Baru',
            ]);

            // Create OrderItem
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $product->price,
            ]);
        });

        return redirect()->to(route('home') . '#products')
                         ->with('success', 'Pesanan Anda berhasil dibuat! Pembelian tercatat di database.');
    }
}
