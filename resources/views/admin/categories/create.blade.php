@extends('layouts.app')
@section('title', 'Add Category')

@section('content')
<div class="bg-white p-6 rounded shadow-sm max-w-2xl mx-auto border-t-4 border-blue-600">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Category Name (e.g., AC Repair)</label>
            <input type="text" name="name" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-6 flex items-center">
            <input type="checkbox" name="is_active" value="1" id="is_active" class="mr-2 h-4 w-4 text-blue-600" checked>
            <label for="is_active" class="text-gray-700 font-bold">Category is Active</label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Save Category</button>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">Cancel</a>
        </div>
    </form>
</div>
@endsection