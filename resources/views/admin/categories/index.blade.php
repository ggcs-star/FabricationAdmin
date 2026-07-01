@extends('layouts.admin')
@section('title', 'Categories | FabriQ Admin')
@section('page_title', 'Categories')
@section('page_subtitle', 'Organize products and services into categories')

@section('content')
<div class="bg-white rounded-xl border border-gray-200">
    <div class="flex flex-wrap justify-between items-center gap-3 p-5 border-b border-gray-100">
        <div></div>
        <a href="{{ route('admin.categories.create') }}" class="bg-fabriq-500 hover:bg-fabriq-600 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Category</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-5 py-3">Name</th>
                    <th class="text-left px-5 py-3">Slug</th>
                    <th class="text-left px-5 py-3">Products</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr class="border-t border-gray-100 hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $category->name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $category->slug }}</td>
                    <td class="px-5 py-3">{{ $category->products_count }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 rounded-full text-xs {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 space-x-3">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
        <div class="p-5 border-t border-gray-100">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
