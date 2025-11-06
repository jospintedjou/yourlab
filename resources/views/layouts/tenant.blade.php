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
                        primary: '#358fbc',
                        'primary-hover': '#2a7199',
                        sidebar: '#F4F5F7',
                        border: '#DFE1E6',
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @livewireStyles
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white border-b border-border shadow-sm">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('organizations.index') }}" class="flex items-center">
                        <img src="{{ asset('img/logo-yourlab-transparent.png') }}" alt="YourLab Logo" class="h-10 w-auto">
                        <span class="ml-3 text-xl font-semibold text-gray-900">{{ tenant('name') }}</span>
                    </a>
                    
                    <div class="hidden md:flex space-x-1">
                        <a wire:navigate href="{{ route('tenant.dashboard', ['tenant' => tenant('id')]) }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('tenant.dashboard') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary hover:border-b-2 hover:border-gray-300' }}">
                            Tableau de bord
                        </a>
                        <a wire:navigate href="{{ route('tenant.projects.index', ['tenant' => tenant('id')]) }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('tenant.projects.*') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary hover:border-b-2 hover:border-gray-300' }}">
                            Projets
                        </a>
                        <a wire:navigate href="{{ route('tenant.tasks.index', ['tenant' => tenant('id')]) }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('tenant.tasks.*') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary hover:border-b-2 hover:border-gray-300' }}">
                            Tâches
                        </a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <livewire:organization-switcher />
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition">
                            <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                             style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
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
