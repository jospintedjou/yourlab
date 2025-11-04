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
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat relative" style="background-image: url('{{ asset('img/bg-img.png') }}');">
        <!-- Overlay for better text readability -->
        <div class="absolute inset-0"></div>
        
        <div class="text-center relative z-10">
            <div class="mb-8 flex justify-center">
                <img src="{{ asset('img/logo-yourlab-transparent.png') }}" alt="YourLab Logo" class="h-48 w-auto drop-shadow-2xl">
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-8 drop-shadow-lg">Bienvenue sur YourLab</h1>
            <p class="text-lg text-gray-900 mb-8 drop-shadow-md">Organisez vos projets efficacement</p>
            
            <div class="space-x-4">
                @auth
                    <a href="{{ route('organizations.index') }}" class="inline-block bg-[#358fbc] text-white px-6 py-3 rounded-lg hover:bg-[#2a7199] transition shadow-lg">
                        Accéder au tableau de bord
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block bg-[#358fbc] text-white px-6 py-3 rounded-lg hover:bg-[#2a7199] transition shadow-lg">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="inline-block bg-white text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-100 transition shadow-lg">
                        S'inscrire
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
