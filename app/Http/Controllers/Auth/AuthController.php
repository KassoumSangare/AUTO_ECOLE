<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    // ──────────────────────────────────────────
    // INSCRIPTION
    // ──────────────────────────────────────────

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'telephone'=> $request->telephone,
            'email'    => $request->email,
            'password' => $request->password, // auto-hashed via cast
            'role'     => 'eleve',
        ]);

        Auth::login($user);

        return redirect()->route('eleve.dashboard')
                         ->with('success', "Bienvenue {$user->prenom} ! Votre compte a été créé.");
    }

    // ──────────────────────────────────────────
    // CONNEXION
    // ──────────────────────────────────────────

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = [
            'telephone' => $request->telephone,
            'password'  => $request->password,
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('telephone'))
                ->withErrors(['telephone' => 'Numéro de téléphone ou mot de passe incorrect.']);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('eleve.dashboard'));
    }

    // ──────────────────────────────────────────
    // DÉCONNEXION
    // ──────────────────────────────────────────

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}