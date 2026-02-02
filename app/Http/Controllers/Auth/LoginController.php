<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Gérer la tentative de connexion
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Vérifier si l'utilisateur a fait trop de tentatives
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // Tenter de connecter l'utilisateur
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // Incrémenter le compteur de tentatives
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Valider les données de connexion
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);
    }

    /**
     * Tenter de connecter l'utilisateur
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    /**
     * Obtenir les credentials pour la connexion
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Envoyer la réponse après une connexion réussie
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * L'utilisateur a été authentifié - Redirection selon le rôle
     */
    protected function authenticated(Request $request, $user)
    {
        // Vérifier si l'utilisateur est banni ou suspendu
        if (isset($user->is_banned) && $user->is_banned) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre compte a été banni. Contactez l\'administrateur.');
        }

        if (isset($user->is_suspended) && $user->is_suspended) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre compte a été suspendu. Contactez l\'administrateur.');
        }

        // Redirection selon le rôle
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard')->with('success', 'Bienvenue ' . $user->name . ' !'),
            'organizer' => redirect()->route('organizer.dashboard')->with('success', 'Bienvenue ' . $user->name . ' !'),
            'member' => redirect()->route('member.dashboard')->with('success', 'Bienvenue ' . $user->name . ' !'),
            default => redirect()->route('home')->with('success', 'Bienvenue ' . $user->name . ' !'),
        };
    }

    /**
     * Envoyer la réponse après un échec de connexion
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => ['Les informations de connexion sont incorrectes.'],
        ]);
    }

    /**
     * Déconnecter l'utilisateur
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Obtenir le guard utilisé
     */
    protected function guard()
    {
        return Auth::guard();
    }
}