@extends('layouts.app')
@section('title', 'Manage Services')

@section('content')
<div class="bg-white p-6 rounded shadow-sm border-t-4 border-purple-600">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Services Catalog</h1>
        <a href="{{ route('admin.services.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">+ Add New Service</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Service Name</th>
                    <th class="py-2 px-4 border-b text-left">Category</th>
                    <th class="py-2 px-4 border-b text-left">Base Price (₹)</th>
                    <th class="py-2 px-4 border-b text-left">Duration</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b font-medium">{{ $service->name }}</td>
                    <td class="py-2 px-4 border-b text-gray-600">{{ $service->category->name }}</td>
                    <td class="py-2 px-4 border-b font-bold text-green-600">₹{{ number_format($service->base_price, 2) }}</td>
                    <td class="py-2 px-4 border-b">{{ $service->duration_minutes }} mins</td>
                    <td class="py-2 px-4 border-b">
                        <a href="#" class="text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-500">No services found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection