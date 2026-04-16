<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire d'édition du profil admin.
     */
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Met à jour les informations du profil admin.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();

        // Mise à jour des informations validées
        $user->update($request->validated());

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Met à jour le mot de passe de l'admin.
     */
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = auth()->user();

        // Mise à jour du mot de passe (auto-hashé grâce au cast dans le modèle)
        $user->update([
            'password' => $request->validated()['password'],
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Mot de passe modifié avec succès.');
    }
}