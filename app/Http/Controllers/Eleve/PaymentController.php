<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PdfReceiptService;
use App\Services\WavePaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private PdfReceiptService  $pdfService,
    ) {}

    // ──────────────────────────────────────────
    // PAGE PAIEMENT
    // ──────────────────────────────────────────

    public function index(): View
    {
        $user        = Auth::user();
        $hasPaid     = $user->hasPaid();
        $lastPayment = $user->payments()->latest()->first();
        $amount      = config('services.wave.montant_inscription', 50000);

        return view('eleve.payment', compact('user', 'hasPaid', 'lastPayment', 'amount'));
    }

    // ──────────────────────────────────────────
    // INITIER LE PAIEMENT
    // ──────────────────────────────────────────

    public function initiate(Request $request): RedirectResponse
    {
        $wave = app(WavePaymentService::class);
        $user = Auth::user();

        if ($user->hasPaid()) {
            return back()->with('info', 'Vous avez déjà effectué votre paiement.');
        }

        $pending = $user->payments()->where('status', 'pending')->first();
        if ($pending) {
            return back()->with('warning', 'Un paiement est déjà en cours. Veuillez finaliser ou patienter.');
        }

        DB::beginTransaction();
        try {
            $montant = (int) config('services.wave.montant_inscription', 50000);

            $payment = Payment::create([
                'user_id'        => $user->id,
                'reference_wave' => 'PENDING-' . uniqid(),
                'amount'         => $montant,
                'currency'       => 'XOF',
                'status'         => 'pending',
                'receipt_number' => Payment::generateReceiptNumber(),
            ]);

            $checkout = $wave->createCheckout([
                'amount'      => $montant,
                'currency'    => 'XOF',
                'reference'   => "AUTO-ECOLE-{$payment->id}",
                'success_url' => route('eleve.payment.success', ['payment' => $payment->id]),
                'error_url'   => route('eleve.payment') . '?error=1',
            ]);

            $payment->update([
                'reference_wave'   => $checkout['checkout_id'],
                'wave_checkout_id' => $checkout['checkout_id'],
            ]);

            DB::commit();

            return redirect()->away($checkout['wave_launch_url']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur initiation paiement Wave', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
            return back()->with('error', $e->getMessage());
        }
    }

    // ──────────────────────────────────────────
    // RETOUR APRÈS PAIEMENT (success_url)
    // ──────────────────────────────────────────

    public function success(Request $request): View|RedirectResponse
    {
        $wave      = app(WavePaymentService::class);
        $paymentId = $request->query('payment');
        $payment   = Payment::where('id', $paymentId)
                            ->where('user_id', Auth::id())
                            ->first();

        if (! $payment) {
            return redirect()->route('eleve.payment')->with('error', 'Paiement introuvable.');
        }

        // Vérification Wave si webhook pas encore reçu
        if ($payment->status === 'pending' && $payment->wave_checkout_id) {
            try {
                $waveData  = $wave->getCheckoutStatus($payment->wave_checkout_id);
                $newStatus = $wave->mapStatus($waveData['payment_status'] ?? 'pending');
                if ($newStatus === 'completed') {
                    $this->finalizePayment($payment, $waveData);
                }
            } catch (\Exception $e) {
                Log::warning('Vérification Wave post-redirect échouée', ['error' => $e->getMessage()]);
            }
        }

        $payment->refresh();

        return view('eleve.payment-success', compact('payment'));
    }

    // ──────────────────────────────────────────
    // WEBHOOK WAVE
    // ──────────────────────────────────────────

    public function webhook(Request $request)
    {
        $wave       = app(WavePaymentService::class);
        $rawPayload = $request->getContent();
        $sigHeader  = $request->header('wave-signature', '');

        if (! $wave->verifyWebhookSignature($rawPayload, $sigHeader)) {
            Log::warning('Wave Webhook — Signature invalide', ['ip' => $request->ip()]);
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = $request->json()->all();

        Log::info('Wave Webhook reçu', ['type' => $data['type'] ?? 'unknown']);

        if (($data['type'] ?? '') !== 'checkout.session.completed') {
            return response()->json(['status' => 'ignored']);
        }

        $checkoutId = $data['data']['id'] ?? null;
        if (! $checkoutId) {
            return response()->json(['error' => 'Missing checkout id'], 400);
        }

        $payment = Payment::where('wave_checkout_id', $checkoutId)
                          ->where('status', 'pending')
                          ->first();

        if (! $payment) {
            return response()->json(['status' => 'already_processed']);
        }

        try {
            $this->finalizePayment($payment, $data['data']);
        } catch (\Exception $e) {
            Log::error('Webhook Wave — Erreur finalisation', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Processing failed'], 500);
        }

        return response()->json(['status' => 'success']);
    }

    // ──────────────────────────────────────────
    // FINALISATION COMMUNE
    // ──────────────────────────────────────────

    private function finalizePayment(Payment $payment, array $waveData): void
    {
        DB::transaction(function () use ($payment, $waveData) {
            $receiptPath = $this->pdfService->generate($payment);

            $payment->update([
                'status'       => 'completed',
                'receipt_path' => $receiptPath,
                'wave_payload' => $waveData,
                'paid_at'      => now(),
            ]);

            $user = $payment->user;
            if ($user->email) {
                Log::info("Email reçu à envoyer à {$user->email} — reçu #{$payment->receipt_number}");
                // TODO: Mail::to($user->email)->send(new PaymentConfirmedMail($payment));
            }
        });
    }

    // ──────────────────────────────────────────
    // TÉLÉCHARGER LE REÇU PDF
    // ──────────────────────────────────────────

    public function downloadReceipt(Payment $payment): mixed
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        if ($payment->status !== 'completed') {
            return back()->with('error', 'Le reçu n\'est disponible qu\'après confirmation du paiement.');
        }

        return $this->pdfService->download($payment);
    }
    }