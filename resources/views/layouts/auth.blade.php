<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard | Fabrication')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-900 flex h-screen overflow-hidden">

    <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">
        <div class="h-16 flex items-center justify-center border-b border-gray-800">
            <h2 class="text-2xl font-bold text-white tracking-widest">RATHAYA <span class="text-blue-500">APEX</span></h2>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            @role('admin')
                <p class="text-xs text-gray-400 font-bold uppercase mt-4 mb-2">Admin Controls</p>
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">Dashboard</a>
                <a href="{{ route('admin.vendors.pending') }}" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.vendors.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">Partner Approvals</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-800">Service Categories</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-800">All Services</a>
            @endrole

            @role('vendor')
                <p class="text-xs text-gray-400 font-bold uppercase mt-4 mb-2">Partner Controls</p>
                <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('vendor.dashboard') ? 'bg-gray-800 border-l-4 border-green-500' : '' }}">Dashboard</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-800">My Services</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-800">Active Bookings</a>
            @endrole
        </nav>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <header class="h-16 bg-white shadow flex items-center justify-between px-6 z-10">
            <button class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            
            <div class="font-semibold text-gray-800 truncate">
                @yield('header_title', 'Overview')
            </div>

            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                    {{ ucfirst(auth()->user()->roles->pluck('name')->first()) }}
                </span>
                <span class="text-gray-800 font-bold">{{ auth()->user()->name }}</span>
                
                <form action="{{ route('logout') }}" method="POST" class="inline border-l pl-4 ml-2 border-gray-300">
                    @csrf
                    <button type="submit" class="text-red-500 font-bold hover:underline">Logout</button>
                </form>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>