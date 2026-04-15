@extends('layouts.app')

@section('title', 'Historique des paiements')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8 text-gray-900">📋 Historique des paiements</h1>

    @if ($orders->isEmpty())
        <div class="bg-gray-50 rounded-lg p-8 text-center">
            <p class="text-gray-600">Aucun paiement effectué pour le moment</p>
            <a href="{{ route('payment.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                Effectuer un paiement
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Réf.</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Montant</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Statut</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-900">{{ $order->id }}</td>
                            <td class="px-6 py-3 text-sm font-semibold text-gray-900">
                                {{ number_format($order->amount / 100, 0, ',', ' ') }} {{ $order->currency }}
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600">
                                {{ $order->paid_at?->format('d/m/Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-3 text-sm">
                                @if ($order->status === 'completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        ✅ Complété
                                    </span>
                                @elseif ($order->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        ⏳ En attente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        ❌ Échoué
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-sm text-center">
                                @if ($order->status === 'completed')
                                    <a href="{{ route('payment.receipt', $order) }}" class="text-blue-600 hover:text-blue-900 font-semibold">
                                        Reçu
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
