<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\Order;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CmsController extends Controller
{
    /**
     * Update website settings.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'hero_title' => 'required|string|max:500',
            'hero_subtitle' => 'required|string',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:50',
            'contact_address' => 'required|string',
            'about_text' => 'required|string',
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::setValue($key, $value);
        }

        return redirect()->back()->with('success', 'Tampilan dan isi web berhasil diperbarui!');
    }

    /**
     * Add a new product.
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imageUrl = $validated['image_url'] ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/uploads');
            
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $name);
            $imageUrl = '/uploads/' . $name;
        }

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'stock' => $validated['stock'],
            'image_url' => $imageUrl,
        ]);

        return redirect()->back()->with('success', 'Produk baru berhasil ditambahkan!');
    }

    /**
     * Update an existing product.
     */
    public function updateProduct(Request $request, $id)
    {
        dd('MASUK UPDATE PRODUCT');
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imageUrl = $validated['image_url'] ?? $product->image_url;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/uploads');
            
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $name);
            
            // Delete old local image if exists
            if ($product->image_url && str_starts_with($product->image_url, '/uploads/')) {
                $oldImagePath = public_path($product->image_url);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            
            $imageUrl = '/uploads/' . $name;
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'stock' => $validated['stock'],
            'image_url' => $imageUrl,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete a product.
     */
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);

        // Delete local image if exists
        if ($product->image_url && str_starts_with($product->image_url, '/uploads/')) {
            $oldImagePath = public_path($product->image_url);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Add a new category.
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Delete a category.
     */
    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        
        // Prevent deleting last category if needed or just cascade delete
        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:Baru,Dibayar,Dikirim,Selesai,Dibatalkan',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Delete a contact message.
     */
    public function destroyMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Pesan masuk berhasil dihapus!');
    }
}
