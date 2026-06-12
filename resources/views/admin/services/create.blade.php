@extends('layouts.app')
@section('title', 'Add Service')

@section('content')
<div class="bg-white p-6 rounded shadow-sm max-w-3xl mx-auto border-t-4 border-purple-600">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Service</h1>

    <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Select Category</label>
                <select name="category_id" class="w-full border p-2 rounded bg-white" required>
                    <option value="">-- Choose Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Service Name</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required placeholder="e.g., Split AC Gas Charge">
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Base Price (₹)</label>
                <input type="number" step="0.01" name="base_price" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Estimated Duration (Minutes)</label>
                <input type="number" name="duration_minutes" class="w-full border p-2 rounded" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Service Description</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="3"></textarea>
        </div>

        <div class="mb-6 flex items-center">
            <input type="checkbox" name="is_active" value="1" id="is_active" class="mr-2 h-4 w-4" checked>
            <label for="is_active" class="text-gray-700 font-bold">Service is Active</label>
        </div>

        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">Save Service</button>
    </form>
</div>
@endsection