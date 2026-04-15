@extends('layouts.app')

@section('title', 'Paiement')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-gray-900">💳 Effectuer un paiement</h1>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-600 p-4 mb-6">
                <h3 class="text-red-800 font-semibold">Erreur</h3>
                <ul class="text-red-700 text-sm mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('payment.initiate') }}" method="POST" id="payment-form">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Montant (XOF)</label>
                    <div class="relative">
                        <input type="number" name="amount" value="50000" min="100" step="100"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <span class="absolute right-4 top-3 text-gray-500">XOF</span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Montant minimum: 100 XOF</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <input type="text" name="description" placeholder="Ex: Inscription formation conduite"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition"
                    id="submit-btn">
                    💳 Payer avec Wave
                </button>
            </form>
        </div>

        <div class="mt-8 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-600">
            <h3 class="font-semibold text-blue-900 mb-2">ℹ️ Informations</h3>
            <ul class="text-gray-700 text-sm space-y-1">
                <li>✅ Paiement sécurisé via Wave Mobile Money</li>
                <li>✅ Reçu PDF automatique après confirmation</li>
                <li>✅ Support client disponible</li>
            </ul>
        </div>
    </div>
</div>

<script>
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        document.getElementById('submit-btn').disabled = true;
        document.getElementById('submit-btn').textContent = '⏳ Traitement...';
    });
</script>
@endsection
