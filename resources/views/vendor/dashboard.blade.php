@extends('layouts.auth')
@section('title', 'Partner Dashboard')

@section('content')
<div class="bg-white p-6 rounded shadow-sm border-l-4 border-green-500">
    <h1 class="text-2xl font-bold mb-2">Welcome to your Dashboard, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-600">Your profile is approved and active. You can now start accepting measurements and bookings.</p>
    
    <div class="mt-6">
        <a href="#" class="bg-green-600 text-white px-4 py-2 rounded shadow">Manage Services</a>
        <a href="#" class="ml-4 text-green-600 hover:underline">View Active Bookings</a>
    </div>
</div>
@endsection