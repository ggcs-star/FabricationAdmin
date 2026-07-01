<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with([
            'vendor:id,business_name',
            'category:id,name',
            'service:id,name',
        ]);

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->integer('vendor_id'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->integer('service_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->string('search') . '%');
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product = Product::create($data);

        return response()->json($product->load(['vendor:id,business_name', 'category:id,name', 'service:id,name']), 201);
    }

    public function show(Product $product)
    {
        return response()->json($product->load(['vendor:id,business_name', 'category:id,name', 'service:id,name']));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'vendor_id' => ['sometimes', 'exists:vendors,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'description' => ['nullable', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
        ]);

        if (!array_key_exists('slug', $data) && array_key_exists('name', $data)) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        return response()->json($product->fresh()->load(['vendor:id,business_name', 'category:id,name', 'service:id,name']));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
