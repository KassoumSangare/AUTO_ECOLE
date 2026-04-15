<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessWavePayment;
use App\Models\Order;
use App\Services\WavePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(
        private WavePaymentService $waveService,
    ) {}

    /**
     * Traiter les webhooks de Wave
     */
    public function handleWaveWebhook(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        // Logger l'événement
        Log::info('Wave Webhook reçu', [
            'type' => $data['type'] ?? 'unknown',
            'timestamp' => now(),
        ]);

        // Vérifier le type d'événement
        $eventType = $data['type'] ?? '';

        if ($eventType === 'checkout.session.completed') {
            return $this->handleCheckoutCompleted($data);
        }

        if ($eventType === 'checkout.session.processing') {
            return $this->handleCheckoutProcessing($data);
        }

        if ($eventType === 'checkout.session.failed') {
            return $this->handleCheckoutFailed($data);
        }

        // Événement ignoré
        return response()->json(['status' => 'ignored'], 200);
    }

    /**
     * Gestion du paiement complété
     */
    private function handleCheckoutCompleted(array $data): JsonResponse
    {
        try {
            $checkoutData = $data['data'] ?? [];
            $metadata = $checkoutData['metadata'] ?? [];
            $orderId = $metadata['order_id'] ?? null;

            if (!$orderId) {
                Log::warning('Wave webhook: No order_id in metadata', ['data' => $data]);
                return response()->json(['status' => 'error'], 400);
            }

            $order = Order::findOrFail($orderId);

            // Dispatcher le job asynchrone
            ProcessWavePayment::dispatch($order, $checkoutData);

            Log::info('Wave payment job dispatched', ['order_id' => $orderId]);

            // Répondre rapidement avec 200 OK
            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('Wave webhook error', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Gestion du paiement en cours
     */
    private function handleCheckoutProcessing(array $data): JsonResponse
    {
        Log::info('Wave checkout processing', ['data' => $data]);
        return response()->json(['status' => 'processing'], 200);
    }

    /**
     * Gestion du paiement échoué
     */
    private function handleCheckoutFailed(array $data): JsonResponse
    {
        try {
            $checkoutData = $data['data'] ?? [];
            $metadata = $checkoutData['metadata'] ?? [];
            $orderId = $metadata['order_id'] ?? null;

            if ($orderId) {
                $order = Order::findOrFail($orderId);
                $order->update(['status' => 'failed']);
                Log::info('Wave payment failed', ['order_id' => $orderId]);
            }

            return response()->json(['status' => 'failed'], 200);

        } catch (\Exception $e) {
            Log::error('Wave webhook failed error', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error'], 500);
        }
    }
}

