<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'YourLab') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#358fbc',
                            'primary-hover': '#2a7199',
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center bg-no-repeat relative" style="background-image: url('{{ asset('img/bg-img.png') }}');">
            <!-- Overlay for better readability -->
            <div class="absolute inset-0 bg-white/10"></div>
            
            <div class="relative z-10">
                <a href="/">
                    <img src="{{ asset('img/logo-yourlab-transparent.png') }}" alt="YourLab Logo" class="w-32 h-32 drop-shadow-2xl mx-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-xl mt-6 px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-lg relative z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
