@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white p-6 rounded shadow-sm">
    <h1 class="text-2xl font-bold mb-4">Admin Control Panel</h1>
    <p class="text-gray-600 mb-6">Manage your marketplace, approve vendors, and track platform revenue.</p>
    
    <div class="grid grid-cols-3 gap-4">
        <div class="p-4 bg-blue-50 border border-blue-200 rounded">
            <h3 class="font-bold text-blue-800">Vendor Approvals</h3>
            <p class="text-sm mt-2 text-gray-600">Review pending vendor applications.</p>
            <a href="{{ route('admin.vendors.pending') }}" class="text-blue-600 underline mt-2 inline-block">View Pending</a>
        </div>
        </div>
</div>
@endsection