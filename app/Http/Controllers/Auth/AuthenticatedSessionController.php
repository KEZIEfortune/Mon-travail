<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la vue de connexion.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Gère la tentative d'authentification.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Utilise la route 'dashboard' qui fait l'aiguillage selon le rôle
        $user = Auth::user();

    // Redirection sur mesure selon le rôle
    if ($user->role === 'admin') {
        return redirect()->intended(route('admin.dashboard'));
    } 
    
    if ($user->role === 'organizer') {
        return redirect()->intended(route('organizer.dashboard'));
    }

    // Par défaut pour les membres simples
    return redirect()->intended(route('member.dashboard'));
    }

    /**
     * Détruit une session authentifiée (Déconnexion).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}