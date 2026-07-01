@extends('layouts.admin')
@section('title', 'Dashboard | FabriQ Admin')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Manage fabrication categories, vendors, services & products')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('admin.categories.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
        <p class="text-sm text-gray-500">Categories</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Category::count() }}</p>
    </a>
    <a href="{{ route('admin.vendors.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
        <p class="text-sm text-gray-500">Vendors</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Vendor::count() }}</p>
    </a>
    <a href="{{ route('admin.services.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
        <p class="text-sm text-gray-500">Services</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Service::count() }}</p>
    </a>
    <a href="{{ route('admin.products.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
        <p class="text-sm text-gray-500">Products</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Product::count() }}</p>
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="text-lg font-semibold mb-2">Quick Start</h2>
    <p class="text-gray-600 mb-4">Add data here — it will appear on customer APIs automatically.</p>
    <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
        <li>Create <a href="{{ route('admin.categories.create') }}" class="text-fabriq-600 font-medium">Categories</a> (Steel Structure, Glass Work, etc.)</li>
        <li>Add <a href="{{ route('admin.vendors.create') }}" class="text-fabriq-600 font-medium">Vendors</a> with status <strong>approved</strong></li>
        <li>Add <a href="{{ route('admin.services.create') }}" class="text-fabriq-600 font-medium">Services</a> linked to vendor + category</li>
        <li>Add <a href="{{ route('admin.products.create') }}" class="text-fabriq-600 font-medium">Products</a> (gates, railings, etc.)</li>
        <li>Check customer API: <a href="{{ url('/api/customer/categories') }}" target="_blank" class="text-fabriq-600 font-medium">/api/customer/categories</a></li>
    </ol>
</div>
@endsection
