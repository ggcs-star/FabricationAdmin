<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rathaya Apex Platform')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-900">

    <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-blue-600">Rathaya Apex</a>
        <div>
            @auth
                <span class="mr-4 text-gray-600">Welcome, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 mr-4">Partner Login</a>
                <a href="{{ route('vendor.register') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow">Join as Partner</a>
            @endauth
        </div>
    </nav>

    <div class="max-w-4xl mx-auto mt-4 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <main class="max-w-7xl mx-auto py-8 px-4">
        @yield('content')
    </main>

</body>
</html>