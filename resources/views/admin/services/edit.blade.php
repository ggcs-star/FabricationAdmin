@extends('layouts.admin')
@section('title', 'Edit Service | FabriQ Admin')
@section('page_title', 'Edit Service')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-3xl">
    <form action="{{ route('admin.services.update', $service) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vendor *</label>
                <select name="vendor_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ old('vendor_id', $service->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->business_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service Name *</label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Base Price (₹) *</label>
                <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $service->base_price) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="active" {{ old('status', $service->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $service->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('description', $service->description) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-fabriq-500 hover:bg-fabriq-600 text-white px-5 py-2 rounded-lg">Update</button>
            <a href="{{ route('admin.services.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg">Cancel</a>
        </div>
    </form>
</div>
@endsection
