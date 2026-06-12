@extends('layouts.app')
@section('title', 'Admin Login')

@section('content')
<div class="flex justify-center items-center mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md border-t-4 border-red-600">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Admin Portal</h2>

        <form action="{{ url('admin/login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email Address</label>
                <input type="email" name="email" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500" required placeholder="admin@rathaya.com">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500" required placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-bold py-2 rounded hover:bg-red-700 transition">Secure Login</button>
        </form>
    </div>
</div>
@endsection