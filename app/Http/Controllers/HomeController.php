<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display the store home page.
     */
    public function index(Request $request)
    {
        // Toggle view mode for admins
        if ($request->has('view')) {
            if ($request->view === 'website') {
                session(['admin_view_website' => true]);
            } elseif ($request->view === 'cms') {
                session(['admin_view_website' => false]);
            }
            
            // Remove the query parameter from URL
            return redirect()->route('home');
        }

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

        $users = collect();

        if (Auth::check()) {
            if (Auth::user()->role === 'super_admin') {
                $users = User::latest()->get();
            } elseif (Auth::user()->role === 'admin') {
                $users = User::where('role', 'user')->latest()->get();
            }
        }

        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') && !session('admin_view_website', false)) {
            return view('admin.dashboard', compact('products', 'settings', 'categories', 'orders', 'messages', 'users'));
        }

        return view('home', compact('products', 'settings', 'categories', 'orders', 'messages', 'users'));
    }

    /**
     * Display products catalog page.
     */
    public function products(Request $request)
    {
        $settings = SiteSetting::pluck('value', 'key')->all();
        $categories = Category::all();
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

        return view('products', compact('products', 'settings', 'categories'));
    }

    /**
     * Display about us page.
     */
    public function about()
    {
        $settings = SiteSetting::pluck('value', 'key')->all();
        return view('about', compact('settings'));
    }

    /**
     * Display contact page.
     */
    public function contactPage()
    {
        $settings = SiteSetting::pluck('value', 'key')->all();
        return view('contact', compact('settings'));
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

        return redirect()->to(route('contact.page'))
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

        return redirect()->to(route('products'))
                         ->with('success', 'Pesanan Anda berhasil dibuat! Pembelian tercatat di database.');
    }
}
