<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'       => ['required', 'string', 'max:80', 'regex:/^[\pL\s\-]+$/u'],
            'prenom'    => ['required', 'string', 'max:80', 'regex:/^[\pL\s\-]+$/u'],
            'telephone' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:users,telephone'],
            'email'     => ['nullable', 'email', 'max:150', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'          => 'Le nom est obligatoire.',
            'nom.regex'             => 'Le nom ne doit contenir que des lettres.',
            'prenom.required'       => 'Le prénom est obligatoire.',
            'prenom.regex'          => 'Le prénom ne doit contenir que des lettres.',
            'telephone.required'    => 'Le numéro de téléphone est obligatoire.',
            'telephone.regex'       => 'Le numéro doit contenir exactement 10 chiffres (ex: 0701234567).',
            'telephone.unique'      => 'Ce numéro est déjà enregistré. Connectez-vous.',
            'email.unique'          => 'Cet email est déjà utilisé.',
            'password.required'     => 'Le mot de passe est obligatoire.',
            'password.min'          => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed'    => 'Les mots de passe ne correspondent pas.',
        ];
    }
}
