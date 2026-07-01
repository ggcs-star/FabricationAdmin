@extends('layouts.admin')
@section('title', 'Products | FabriQ Admin')
@section('page_title', 'Products')
@section('page_subtitle', 'Gates, railings, windows and other fabrication products')

@section('content')
<div class="bg-white rounded-xl border border-gray-200">
    <div class="flex justify-end p-5 border-b border-gray-100">
        <a href="{{ route('admin.products.create') }}" class="bg-fabriq-500 hover:bg-fabriq-600 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Product</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-5 py-3">Product</th>
                    <th class="text-left px-5 py-3">Category</th>
                    <th class="text-left px-5 py-3">Vendor</th>
                    <th class="text-left px-5 py-3">Price From (₹)</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-t border-gray-100 hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $product->name }}</td>
                    <td class="px-5 py-3">{{ $product->category?->name ?? '-' }}</td>
                    <td class="px-5 py-3">{{ $product->vendor?->business_name ?? '-' }}</td>
                    <td class="px-5 py-3 text-fabriq-600 font-semibold">₹{{ number_format($product->price, 0) }}</td>
                    <td class="px-5 py-3 capitalize">{{ $product->status }}</td>
                    <td class="px-5 py-3 space-x-3">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())<div class="p-5">{{ $products->links() }}</div>@endif
</div>
@endsection
