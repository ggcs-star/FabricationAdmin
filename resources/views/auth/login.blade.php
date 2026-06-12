@extends('layouts.guest')
@section('title', 'Partner Login')

@section('content')
<div class="flex justify-center items-center mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md border-t-4 border-gray-800">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Partner Login</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>
            <button type="submit" class="w-full bg-gray-800 text-white font-bold py-2 rounded hover:bg-gray-900 transition">Login</button>
        </form>
        <div class="mt-4 text-center">
            <a href="{{ route('vendor.register') }}" class="text-gray-600 hover:underline">New here? Apply as Partner.</a>
        </div>
    </div>
</div>
@endsection