<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'telephone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'password'  => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.regex'    => 'Format invalide (10 chiffres requis).',
            'password.required'  => 'Le mot de passe est obligatoire.',
        ];
    }
}
