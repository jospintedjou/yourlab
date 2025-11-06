<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organisation introuvable</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8 text-center">
            <div class="mb-6">
                <svg class="mx-auto h-16 w-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-4">404</h1>
            <h2 class="text-xl font-semibold text-gray-800 mb-3">Organisation introuvable</h2>
            
            <p class="text-gray-600 mb-6">
                L'organisation <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $tenant_id }}</span> n'existe pas ou a été supprimée.
            </p>
            
            <div class="space-y-3">
                <a href="{{ url('/') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    Retour à l'accueil
                </a>
                <p class="text-sm text-gray-500">
                    Vérifiez l'URL ou contactez votre administrateur.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
