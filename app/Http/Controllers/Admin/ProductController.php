<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['vendor:id,business_name', 'category:id,name', 'service:id,name'])
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $vendors = Vendor::where('status', 'approved')->orderBy('business_name')->get();
        $services = Service::where('status', 'active')->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'vendors', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['stock'] = $data['stock'] ?? 0;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $vendors = Vendor::where('status', 'approved')->orderBy('business_name')->get();
        $services = Service::where('status', 'active')->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'vendors', 'services'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['stock'] = $data['stock'] ?? 0;

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
