@extends('layouts.app')

@section('title', 'Erreur de paiement')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <!-- Icône d'erreur -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-red-600 mb-2">❌ Paiement échoué</h1>
            <p class="text-gray-600">Une erreur est survenue lors de votre paiement</p>
        </div>

        <!-- Détails -->
        <div class="bg-red-50 border-l-4 border-red-600 p-4 mb-6">
            <h2 class="font-semibold text-red-900 mb-2">Ce qui s'est passé:</h2>
            <ul class="text-red-700 text-sm space-y-1">
                <li>• Votre paiement n'a pas été complété</li>
                <li>• Vous n'avez pas été débité</li>
                <li>• Veuillez réessayer ou contacter le support</li>
            </ul>
        </div>

        <!-- Actions -->
        <div class="space-y-3">
            <a href="{{ route('payment.index') }}" class="block text-center py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                🔄 Réessayer le paiement
            </a>
            <a href="{{ route('eleve.dashboard') }}" class="block text-center py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold rounded-lg transition">
                Retour au tableau de bord
            </a>
        </div>
    </div>
</div>
@endsection
