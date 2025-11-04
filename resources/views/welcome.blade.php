<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to YourLab</title>
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
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <div class="mb-8 flex justify-center">
                <img src="{{ asset('img/logo-yourlab.png') }}" alt="YourLab Logo" class="h-48 w-auto">
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Welcome to YourLab</h1>
            <p class="text-lg text-gray-600 mb-8">Organize your projects efficiently</p>
            
            <div class="space-x-4">
                @auth
                    <a href="{{ route('organizations.index') }}" class="inline-block bg-[#358fbc] text-white px-6 py-3 rounded-lg hover:bg-[#2a7199] transition">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block bg-[#358fbc] text-white px-6 py-3 rounded-lg hover:bg-[#2a7199] transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="inline-block bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                        Sign Up
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
