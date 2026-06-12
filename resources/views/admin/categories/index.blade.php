@extends('layouts.app')
@section('title', 'Manage Categories')

@section('content')
<div class="bg-white p-6 rounded shadow-sm border-t-4 border-blue-600">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Service Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add New Category</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID</th>
                    <th class="py-2 px-4 border-b text-left">Category Name</th>
                    <th class="py-2 px-4 border-b text-left">Status</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $category->id }}</td>
                    <td class="py-2 px-4 border-b font-medium">{{ $category->name }}</td>
                    <td class="py-2 px-4 border-b">
                        <span class="{{ $category->is_active ? 'text-green-600' : 'text-red-600' }} font-bold">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="#" class="text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">No categories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection