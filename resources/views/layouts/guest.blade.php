<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome | Rathaya Apex')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

    <nav class="bg-white shadow-sm p-4 flex justify-between items-center max-w-7xl mx-auto rounded-b-lg">
        <a href="/" class="text-2xl font-bold text-blue-600 tracking-tight">Rathaya Apex</a>
        <div>
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 mr-4 font-medium">Login</a>
            <a href="{{ route('vendor.register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-md shadow hover:bg-blue-700 transition">Join as Partner</a>
        </div>
    </nav>

    <div class="max-w-md md:max-w-2xl mx-auto mt-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-4">
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