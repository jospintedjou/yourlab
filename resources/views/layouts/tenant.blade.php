<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - {{ tenant('name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0052CC',
                        'primary-hover': '#0065FF',
                        sidebar: '#F4F5F7',
                        border: '#DFE1E6',
                    }
                }
            }
        }
    </script>
    @livewireStyles
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white border-b border-border shadow-sm">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('organizations.index') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                        </svg>
                        <span class="ml-2 text-xl font-semibold text-gray-900">{{ tenant('name') }}</span>
                    </a>
                    
                    <div class="hidden md:flex space-x-1">
                        <a href="{{ route('tenant.dashboard', ['tenant' => tenant('id')]) }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('tenant.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('tenant.projects.index', ['tenant' => tenant('id')]) }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('tenant.projects.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            Projects
                        </a>
                        <a href="{{ route('tenant.tasks.index', ['tenant' => tenant('id')]) }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('tenant.tasks.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            Tasks
                        </a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <livewire:organization-switcher />
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-12xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    @livewireScripts
</body>
</html>
