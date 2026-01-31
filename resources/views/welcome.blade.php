<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eventus - Inscription</title>

    <script src="https://cdn.tailwindcss.com"></script>
   <header class="w-full flex justify-between items-center p-6 absolute top-0 left-0 right-0 z-50">
        
        <a href="/" class="flex-shrink-0">
            <img src="{{ asset('logo.jpeg') }}" alt="Eventus Logo" class="h-16 w-auto object-contain">
        </a>

        @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 bg-white/80 px-4 py-2 rounded-lg backdrop-blur-sm transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 bg-white/80 px-4 py-2 rounded-lg backdrop-blur-sm transition">
                        Connexion
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition shadow-md">
                            Inscription
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col items-center justify-center p-4">

    <header class="w-full max-w-6xl flex justify-end mb-8 absolute top-4 right-4">
        @if (Route::has('login'))
            <nav class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900">Se connecter</a>
                @endauth
            </nav>
        @endif
    </header>

    <main class="w-full max-w-6xl">
        
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold mb-4 text-gray-900">Créez votre compte et commencez à profiter</h1>
            <p class="text-lg text-gray-600">Choisissez le profil qui vous correspond le mieux</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-blue-100 flex flex-col h-full">
                <div class="text-center mb-6">
                    <span class="text-5xl">👤</span>
                    <h3 class="text-2xl font-bold mt-4 text-blue-900">Membre</h3>
                </div>
                
                <h4 class="text-lg font-semibold text-center mb-6">Découvrez et réservez vos événements préférés</h4>
                
                <ul class="space-y-3 mb-8 flex-1 text-gray-600">
                    <li class="flex items-center">✅ <span class="ml-2">Réservez vos places facilement</span></li>
                    <li class="flex items-center">✅ <span class="ml-2">Recommandations personnalisées</span></li>
                    <li class="flex items-center">✅ <span class="ml-2">Partagez vos avis</span></li>
                </ul>

                <a href="{{ route('register', ['role' => 'member']) }}" 
                   class="block w-full py-4 bg-blue-600 text-white text-center font-bold rounded-xl hover:bg-blue-700 transition transform hover:scale-105">
                    S'inscrire comme Membre
                </a>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg border border-purple-100 flex flex-col h-full">
                <div class="text-center mb-6">
                    <span class="text-5xl">🎭</span>
                    <h3 class="text-2xl font-bold mt-4 text-purple-900">Organisateur</h3>
                </div>

                <h4 class="text-lg font-semibold text-center mb-6">Publiez et gérez vos événements culturels</h4>

                <ul class="space-y-3 mb-8 flex-1 text-gray-600">
                    <li class="flex items-center">✅ <span class="ml-2">Créez et publiez vos événements</span></li>
                    <li class="flex items-center">✅ <span class="ml-2">Gérez les réservations en temps réel</span></li>
                    <li class="flex items-center">✅ <span class="ml-2">Touchez une large audience</span></li>
                </ul>

                <a href="{{ route('register', ['role' => 'organizer']) }}" 
                    class="block w-full py-4 bg-blue-600 text-black text-center font-bold rounded-xl hover:bg-blue-700 transition transform hover:scale-105">
                    S'inscrire comme Organisateur
                </a>
            </div>

        </div>
    </main>

</body>
</html>