<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PdfReceiptService;
use App\Services\WavePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        private PdfReceiptService $pdfService,
        private WavePaymentService $waveService,
    ) {}

    /**
     * Liste les paiements de l'utilisateur
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Initie un paiement Wave
     */
    public function initiate(Request $request): JsonResponse
    {
        $user = Auth::user();

        try {
            $request->validate([
                'amount' => 'required|numeric|min:100',
                'description' => 'nullable|string|max:255',
            ]);

            // Créer la commande
            $order = Order::create([
                'user_id' => $user->id,
                'amount' => (int) $request->amount,
                'currency' => 'XOF',
                'description' => $request->description ?? 'Paiement AUTO-ECOLE',
                'status' => 'pending',
            ]);

            // Initier le checkout Wave
            $checkout = $this->waveService->initiateCheckout([
                'amount' => $order->amount,
                'currency' => 'XOF',
                'reference' => "AUTO-ECOLE-{$order->id}",
                'success_url' => route('payment.success', ['order' => $order->id]),
                'error_url' => route('payment.error', ['order' => $order->id]),
                'metadata' => ['order_id' => $order->id],
            ]);

            if (!$checkout['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'initialisation du paiement',
                ], 400);
            }

            $order->update(['wave_checkout_id' => $checkout['checkout_id']]);

            return response()->json([
                'success' => true,
                'checkout_url' => $checkout['checkout_url'],
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Payment initiation error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function checkStatus(Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'status' => $order->status,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'paid_at' => $order->paid_at,
        ]);
    }

    /**
     * Après succès du paiement
     */
    public function success(Request $request, Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        // Vérifier le statut avec Wave si nécessaire
        if ($order->status === 'pending' && $order->wave_checkout_id) {
            try {
                $waveData = $this->waveService->getCheckoutStatus($order->wave_checkout_id);
                if ($waveData['payment_status'] === 'completed') {
                    $order->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('Wave status check failed', ['error' => $e->getMessage()]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Paiement effectué avec succès',
            'order' => $order,
        ]);
    }

    /**
     * Erreur lors du paiement
     */
    public function error(Request $request, Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        return response()->json([
            'success' => false,
            'message' => 'Paiement échoué ou annulé',
            'order_id' => $order->id,
        ], 400);
    }

    /**
     * Historique des paiements
     */
    public function history(): JsonResponse
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('paid_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders,
            'count' => $orders->count(),
        ]);
    }

    /**
     * Télécharger le reçu PDF
     */
    public function downloadReceipt(Order $order)
    {
        $this->authorize('view', $order);

        if ($order->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Le paiement n\'est pas encore confirmé',
            ], 400);
        }

        try {
            $pdf = $this->pdfService->generateReceipt($order);
            return $pdf->download("receipt-{$order->id}.pdf");
        } catch (\Exception $e) {
            Log::error('Receipt generation error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du reçu',
            ], 500);
        }
    }
}
