<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Category::query();

        if (request()->filled('search')) {
            $query->where('name', 'like', '%' . request()->string('search') . '%');
        }

        if (request()->filled('is_active')) {
            $query->where('is_active', (bool) request()->boolean('is_active'));
        }

        if (request()->filled('is_featured')) {
            $query->where('is_featured', (bool) request()->boolean('is_featured'));
        }

        return response()->json($query->latest()->paginate(15));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
            'visibility' => ['sometimes', Rule::in(['public', 'private'])],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/category');
            $data['image'] = Storage::url($path);
        }

        $category = Category::create($data);

        return response()->json($category, 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
            'visibility' => ['sometimes', Rule::in(['public', 'private'])],
        ]);

        if (!array_key_exists('slug', $data) && array_key_exists('name', $data)) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($category->image) {
                Storage::delete(str_replace('/storage', 'public', $category->image));
            }
            $path = $request->file('image')->store('public/category');
            $data['image'] = Storage::url($path);
        }

        $category->update($data);

        return response()->json($category->fresh());
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::delete(str_replace('/storage', 'public', $category->image));
        }
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}