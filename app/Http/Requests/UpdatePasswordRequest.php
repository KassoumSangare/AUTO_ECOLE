<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true; // L'autorisation est gérée par le middleware
    }

    /**
     * Règles de validation pour le changement de mot de passe.
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'current_password', // Vérifie que c'est bien l'ancien mot de passe
            ],
            'password' => [
                'required',
                'string',
                'confirmed', // Nécessite password_confirmation
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), // Vérifie contre les mots de passe compromis
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'current_password.current_password' => 'Le mot de passe actuel est incorrect.',

            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages d'erreur.
     */
    public function attributes(): array
    {
        return [
            'current_password' => 'mot de passe actuel',
            'password' => 'nouveau mot de passe',
        ];
    }
}
