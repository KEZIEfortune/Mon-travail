<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EVENTUS - Plateforme d\'Événements')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    
    @yield('styles')
    
    @stack('styles')
</head>
<body>
    <!-- ✅ BOUTON DE DÉCONNEXION TEMPORAIRE -->
    <div style="position: fixed; top: 10px; right: 10px; z-index: 9999; background: rgba(0,0,0,0.8); padding: 15px; border-radius: 10px;">
        @auth
            <div style="color: white; margin-bottom: 10px;">
                👤 Connecté: <strong>{{ Auth::user()->name }}</strong>
                <br>
                📋 Rôle: <strong style="color: #fbbf24;">{{ Auth::user()->role }}</strong>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                    🚪 Déconnexion
                </button>
            </form>
        @else
            <span style="background: #10b981; color: white; padding: 10px 15px; border-radius: 5px; display: block; text-align: center;">
                ✅ Non connecté
            </span>
        @endauth
    </div>
    
    @yield('content')
    
    @stack('scripts')
</body>
</html>