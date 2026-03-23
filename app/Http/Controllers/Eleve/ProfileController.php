<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // ──────────────────────────────────────────
    // AFFICHER LE PROFIL
    // ──────────────────────────────────────────

    public function index(): View
    {
        $user = Auth::user()->load(['payments', 'documents', 'quizScores']);

        $stats = [
            'quiz_total'   => $user->quizScores->count(),
            'quiz_reussis' => $user->quizScores->filter(fn($s) => $s->is_reussi)->count(),
            'moy_code'     => $user->quizScores->where('category', 'code')->avg('percentage') ?? 0,
            'moy_conduite' => $user->quizScores->where('category', 'conduite')->avg('percentage') ?? 0,
            'docs_total'   => $user->documents->count(),
            'docs_valides' => $user->documents->where('status', 'valide')->count(),
            'a_paye'       => $user->hasPaid(),
        ];

        return view('eleve.profile', compact('user', 'stats'));
    }

    // ──────────────────────────────────────────
    // METTRE À JOUR LES INFOS
    // ──────────────────────────────────────────

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'nom'       => ['required', 'string', 'max:80', 'regex:/^[\pL\s\-]+$/u'],
            'prenom'    => ['required', 'string', 'max:80', 'regex:/^[\pL\s\-]+$/u'],
            'email'     => ['nullable', 'email', 'max:150', 'unique:users,email,' . $user->id],
        ], [
            'nom.regex'    => 'Le nom ne doit contenir que des lettres.',
            'prenom.regex' => 'Le prénom ne doit contenir que des lettres.',
            'email.unique' => 'Cet email est déjà utilisé par un autre compte.',
        ]);

        $user->update([
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email,
        ]);

        return back()->with('success', 'Vos informations ont été mises à jour.');
    }

    // ──────────────────────────────────────────
    // CHANGER LE MOT DE PASSE
    // ──────────────────────────────────────────

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Veuillez saisir votre mot de passe actuel.',
            'password.confirmed'        => 'Les nouveaux mots de passe ne correspondent pas.',
            'password.min'              => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        $user->update(['password' => $request->password]); // auto-hashed via cast

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }
}
