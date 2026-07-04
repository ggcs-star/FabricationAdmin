@extends('layouts.admin')

@section('page_title', 'Create New Category')
@section('page_subtitle', 'Add a new category to your catalog')

@section('content')
    <div class="mx-auto">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Left Column --}}
                <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-3">Category Information</h3>
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Category Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug (URL-friendly)</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                placeholder="Leave blank to auto-generate from name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Category Image</label>
                            <input type="file" name="image" id="image"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-fabriq-100 file:text-fabriq-700 hover:file:bg-fabriq-200">
                        </div>
                    </div>

                    {{-- SEO Settings --}}
                    <div class="mt-8 pt-6 border-t">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">SEO Settings</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="meta_keywords"
                                    class="block text-sm font-medium text-gray-700">Meta Keywords</label>
                                <input type="text" name="meta_keywords" id="meta_keywords"
                                    value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="meta_description"
                                    class="block text-sm font-medium text-gray-700">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">{{ old('meta_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="md:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 border-b pb-3">Settings</h3>

                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                            <select name="parent_id" id="parent_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">
                                <option value="">-- No Parent --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('parent_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                                min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="is_active" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">
                                <option value="1" @selected(old('is_active', 1))>Active</option>
                                <option value="0" @selected(!old('is_active', 1))>Inactive</option>
                            </select>
                        </div>

                        <div>
                            <label for="visibility" class="block text-sm font-medium text-gray-700">Visibility</label>
                            <select name="visibility" id="visibility"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-fabriq-500 focus:ring-fabriq-500 sm:text-sm">
                                <option value="public" @selected(old('visibility', 'public') == 'public')>Public</option>
                                <option value="private" @selected(old('visibility') == 'private')>Private</option>
                            </select>
                        </div>

                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input id="is_featured" name="is_featured" type="checkbox" value="1"
                                    @checked(old('is_featured'))
                                    class="h-4 w-4 rounded border-gray-300 text-fabriq-600 focus:ring-fabriq-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_featured" class="font-medium text-gray-700">Featured</label>
                                <p class="text-gray-500">Display this category on the homepage.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.categories.index') }}"
                            class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-fabriq-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-fabriq-700 focus:outline-none focus:ring-2 focus:ring-fabriq-500 focus:ring-offset-2">
                            Create Category
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection