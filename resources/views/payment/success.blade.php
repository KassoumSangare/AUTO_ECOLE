@extends('layouts.app')

@section('title', 'Paiement réussi')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <!-- Icône de succès -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-green-600 mb-2">✅ Paiement réussi</h1>
            <p class="text-gray-600">Votre paiement a été traité avec succès</p>
        </div>

        <!-- Détails du paiement -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Détails du paiement</h2>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Montant</p>
                    <p class="font-semibold text-gray-900">{{ number_format($order->amount / 100, 0, ',', ' ') }} {{ $order->currency }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Statut</p>
                    <p class="font-semibold text-green-600">{{ $order->status_label }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Date</p>
                    <p class="font-semibold text-gray-900">{{ $order->paid_at?->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Référence</p>
                    <p class="font-semibold text-gray-900">{{ $order->id }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-3">
            <a href="{{ route('payment.receipt', $order) }}" class="block text-center py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                📄 Télécharger le reçu
            </a>
            <a href="{{ route('eleve.dashboard') }}" class="block text-center py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold rounded-lg transition">
                Retour au tableau de bord
            </a>
        </div>
    </div>
</div>
@endsection
