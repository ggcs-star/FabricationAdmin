<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | FabriQ')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        fabriq: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

<div class="flex min-h-screen">
    <aside class="w-64 bg-gray-900 text-white flex flex-col shrink-0">
        <div class="h-16 flex items-center px-6 border-b border-gray-800">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-wide">
                Fabri<span class="text-fabriq-500">Q</span>
            </a>
            <span class="ml-2 text-xs bg-fabriq-600 px-2 py-0.5 rounded-full">Admin</span>
        </div>

        <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
            <p class="text-xs text-gray-500 font-semibold uppercase px-3 mb-2">Main Menu</p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-fabriq-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.categories.*') ? 'bg-fabriq-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <span>Categories</span>
            </a>

            <a href="{{ route('admin.vendors.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.vendors.*') ? 'bg-fabriq-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <span>Vendors</span>
            </a>

            <a href="{{ route('admin.services.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.services.*') ? 'bg-fabriq-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <span>Services</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.products.*') ? 'bg-fabriq-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <span>Products</span>
            </a>

        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h1>
                @hasSection('page_subtitle')
                    <p class="text-sm text-gray-500">@yield('page_subtitle')</p>
                @endif
            </div>
            <div class="text-sm text-gray-500">FabriQ Admin Panel</div>
        </header>

        <main class="flex-1 p-6 overflow-y-auto">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
