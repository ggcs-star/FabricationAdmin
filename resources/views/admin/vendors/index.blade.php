@extends('layouts.admin')
@section('title', 'Vendors | FabriQ Admin')
@section('page_title', 'Vendors')
@section('page_subtitle', 'Manage fabrication vendors shown on customer site')

@section('content')
<div class="bg-white rounded-xl border border-gray-200">
    <div class="flex flex-wrap justify-between items-center gap-3 p-5 border-b border-gray-100">
        <a href="{{ route('admin.vendors.pending') }}" class="text-sm text-fabriq-600 hover:underline">View Pending Approvals</a>
        <a href="{{ route('admin.vendors.create') }}" class="bg-fabriq-500 hover:bg-fabriq-600 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Vendor</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-5 py-3">Business Name</th>
                    <th class="text-left px-5 py-3">Contact</th>
                    <th class="text-left px-5 py-3">Email / Phone</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                <tr class="border-t border-gray-100 hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $vendor->business_name }}</td>
                    <td class="px-5 py-3">{{ $vendor->user?->name ?? '-' }}</td>
                    <td class="px-5 py-3 text-gray-600">
                        <div>{{ $vendor->user?->email }}</div>
                        <div>{{ $vendor->user?->phone }}</div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 rounded-full text-xs capitalize
                            {{ $vendor->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $vendor->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3 space-x-3">
                        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" class="inline" onsubmit="return confirm('Delete this vendor?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">No vendors yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($vendors->hasPages())
        <div class="p-5 border-t border-gray-100">{{ $vendors->links() }}</div>
    @endif
</div>
@endsection
