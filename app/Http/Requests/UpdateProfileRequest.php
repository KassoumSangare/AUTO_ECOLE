<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true; // L'autorisation est gérée par le middleware
    }

    /**
     * Règles de validation pour la mise à jour du profil.
     */
    public function rules(): array
    {
        return [
            'nom' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/', // Lettres, espaces, tirets, apostrophes
            ],
            'prenom' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'telephone' => [
                'required',
                'string',
                'regex:/^[0-9\s\+\-\(\)]+$/',
                'min:8',
                'max:20',
                Rule::unique('users')->ignore($this->user()->id),
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.regex' => 'Le nom ne peut contenir que des lettres, espaces, tirets et apostrophes.',
            'nom.max' => 'Le nom ne peut dépasser 100 caractères.',

            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.regex' => 'Le prénom ne peut contenir que des lettres, espaces, tirets et apostrophes.',
            'prenom.max' => 'Le prénom ne peut dépasser 100 caractères.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'email.max' => 'L\'adresse email ne peut dépasser 255 caractères.',

            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.regex' => 'Le format du numéro de téléphone n\'est pas valide.',
            'telephone.min' => 'Le numéro de téléphone doit contenir au moins 8 caractères.',
            'telephone.max' => 'Le numéro de téléphone ne peut dépasser 20 caractères.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages d'erreur.
     */
    public function attributes(): array
    {
        return [
            'nom' => 'nom',
            'prenom' => 'prénom',
            'email' => 'email',
            'telephone' => 'téléphone',
        ];
    }
}
