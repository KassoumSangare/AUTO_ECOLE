<?php

namespace App\Jobs;

use App\Mail\PaymentConfirmation;
use App\Models\Order;
use App\Services\PdfReceiptService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessWavePayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public array $waveData = []
    ) {
        $this->queue = 'payments';
        $this->timeout = 120;
    }

    /**
     * Exécuter le job
     */
    public function handle(PdfReceiptService $pdfService): void
    {
        try {
            Log::info('Processing Wave Payment', ['order_id' => $this->order->id]);

            // 1️⃣ Marquer la commande comme complétée
            $this->order->markAsCompleted($this->waveData);
            Log::info('Order marked as completed', ['order_id' => $this->order->id]);

            // 2️⃣ Générer le reçu PDF
            try {
                $receipt = $pdfService->generateReceipt($this->order);
                Log::info('Receipt generated', ['order_id' => $this->order->id]);
            } catch (\Exception $e) {
                Log::error('Receipt generation failed', [
                    'order_id' => $this->order->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // 3️⃣ Envoyer l'email de confirmation
            try {
                Mail::to($this->order->user->email)
                    ->send(new PaymentConfirmation($this->order));
                Log::info('Confirmation email sent', ['order_id' => $this->order->id]);
            } catch (\Exception $e) {
                Log::error('Confirmation email failed', [
                    'order_id' => $this->order->id,
                    'error' => $e->getMessage(),
                ]);
            }

            Log::info('Wave Payment processed successfully', ['order_id' => $this->order->id]);

        } catch (\Exception $e) {
            Log::error('Wave Payment processing failed', [
                'order_id' => $this->order->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Gestion de l'échec du job
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Wave Payment Job failed permanently', [
            'order_id' => $this->order->id,
            'error' => $exception->getMessage(),
        ]);

        // Marquer la commande comme échouée
        $this->order->markAsFailed();
    }
}
