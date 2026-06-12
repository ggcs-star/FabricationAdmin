@extends('layouts.guest')
@section('title', 'Partner Registration')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl border-t-4 border-blue-600">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Become a Partner</h2>
        <p class="text-center text-gray-500 mb-6">Fill in your details to join the Urban Marketplace.</p>

        <form action="{{ route('vendor.register.submit') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Owner Name</label>
                    <input type="text" name="owner_name" value="{{ old('owner_name') }}" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Business/Shop Name</label>
                    <input type="text" name="business_name" value="{{ old('business_name') }}" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">GST Number (Optional)</label>
                    <input type="text" name="gst_number" value="{{ old('gst_number') }}" class="w-full border p-2 rounded">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">Business Address</label>
                    <textarea name="address" class="w-full border p-2 rounded" rows="2" required>{{ old('address') }}</textarea>
                </div>
            </div>

            <button type="submit" class="w-full mt-6 bg-blue-600 text-white font-bold py-3 rounded hover:bg-blue-700 transition">Submit Application</button>
            
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Already have an account? Login here.</a>
            </div>
        </form>
    </div>
</div>
@endsection