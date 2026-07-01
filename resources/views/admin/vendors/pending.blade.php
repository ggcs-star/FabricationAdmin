@extends('layouts.admin')
@section('title', 'Pending Vendors | FabriQ Admin')
@section('page_title', 'Pending Vendor Approvals')

@section('content')
<div class="bg-white rounded-xl border border-gray-200">
    <div class="p-5 border-b border-gray-100">
        <a href="{{ route('admin.vendors.index') }}" class="text-sm text-fabriq-600 hover:underline">&larr; Back to all vendors</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-5 py-3">Business</th>
                    <th class="text-left px-5 py-3">Contact</th>
                    <th class="text-left px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                <tr class="border-t border-gray-100">
                    <td class="px-5 py-3 font-medium">{{ $vendor->business_name }}</td>
                    <td class="px-5 py-3">{{ $vendor->user?->name }} — {{ $vendor->user?->email }}</td>
                    <td class="px-5 py-3 space-x-2">
                        <form action="{{ route('admin.vendors.approve', $vendor->id) }}" method="POST" class="inline">@csrf
                            <button class="text-green-600 hover:underline">Approve</button>
                        </form>
                        <form action="{{ route('admin.vendors.reject', $vendor->id) }}" method="POST" class="inline">@csrf
                            <button class="text-red-600 hover:underline">Reject</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-5 py-8 text-center text-gray-500">No pending vendors.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
