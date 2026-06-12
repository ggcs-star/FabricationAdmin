@extends('layouts.app')
@section('title', 'My Services')

@section('content')
<div class="bg-white p-6 rounded shadow-sm border-t-4 border-green-500">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">My Offered Services</h1>
    <p class="text-gray-600 mb-6">Select the services you want to provide to customers. You will only receive bookings for the services selected below.</p>

    <form action="{{ route('vendor.services.store') }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            @forelse($categories as $category)
                @if($category->services->count() > 0)
                <div class="border p-4 rounded-lg bg-gray-50">
                    <h2 class="text-xl font-bold text-blue-800 mb-3 border-b pb-2">{{ $category->name }}</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($category->services as $service)
                            <label class="flex items-start space-x-3 cursor-pointer bg-white p-3 border rounded shadow-sm hover:border-blue-500">
                                <input type="checkbox" name="services[]" value="{{ $service->id }}" 
                                    class="mt-1 h-5 w-5 text-green-600"
                                    {{ in_array($service->id, $selectedServices) ? 'checked' : '' }}>
                                <div>
                                    <span class="font-bold text-gray-800 block">{{ $service->name }}</span>
                                    <span class="text-sm text-gray-500 block">₹{{ $service->base_price }} • {{ $service->duration_minutes }} mins</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif
            @empty
                <p class="text-red-500">No services available from Admin yet.</p>
            @endforelse
        </div>

        <div class="mt-8">
            <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg font-bold text-lg shadow hover:bg-green-700">
                Save My Services
            </button>
        </div>
    </form>
</div>
@endsection