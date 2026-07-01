@extends('layouts.admin')
@section('title', 'Add Category | FabriQ Admin')
@section('page_title', 'Add Category')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Steel Structure" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fabriq-500 focus:outline-none" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-fabriq-500 focus:outline-none">{{ old('description') }}</textarea>
        </div>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" checked class="rounded text-fabriq-500">
            <span class="text-sm text-gray-700">Active</span>
        </label>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-fabriq-500 hover:bg-fabriq-600 text-white px-5 py-2 rounded-lg">Save</button>
            <a href="{{ route('admin.categories.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
