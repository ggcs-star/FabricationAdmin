@extends('layouts.admin')
@section('title', 'Edit Vendor | FabriQ Admin')
@section('page_title', 'Edit Vendor')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-3xl">
    <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person Name</label>
                <input type="text" name="name" value="{{ old('name', $vendor->user?->name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                <input type="text" name="business_name" value="{{ old('business_name', $vendor->business_name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $vendor->user?->email) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $vendor->user?->phone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    @foreach(['approved','pending','rejected','suspended'] as $status)
                        <option value="{{ $status }}" {{ old('status', $vendor->status) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">GST Number</label>
                <input type="text" name="gst_number" value="{{ old('gst_number', $vendor->gst_number) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">PAN Number</label>
                <input type="text" name="pan_number" value="{{ old('pan_number', $vendor->pan_number) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('address', $vendor->address) }}</textarea>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-fabriq-500 hover:bg-fabriq-600 text-white px-5 py-2 rounded-lg">Update</button>
            <a href="{{ route('admin.vendors.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
