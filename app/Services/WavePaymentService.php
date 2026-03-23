<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WavePaymentService
{
    private ?string $apiKey;
    private string $baseUrl = 'https://api.wave.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.wave.api_key');
    }

    // ──────────────────────────────────────────
    // INITIALISER UNE SESSION DE PAIEMENT
    // ──────────────────────────────────────────

    /**
     * Crée une session checkout Wave et retourne l'URL de paiement.
     *
     * @return array{checkout_id: string, wave_launch_url: string}
     * @throws \Exception
     */
    public function createCheckout(array $params): array
    {
        $payload = [
            'currency'     => $params['currency']    ?? 'XOF',
            'amount'       => (string) $params['amount'],
            'error_url'    => $params['error_url'],
            'success_url'  => $params['success_url'],
            'client_reference' => $params['reference'],  // Notre référence interne
        ];

        $response = Http::withToken($this->apiKey)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post("{$this->baseUrl}/checkout/sessions", $payload);

        if ($response->failed()) {
            Log::error('Wave API - Échec création checkout', [
                'status'  => $response->status(),
                'body'    => $response->body(),
                'payload' => $payload,
            ]);
            throw new \Exception('Impossible d\'initialiser le paiement Wave. Veuillez réessayer.');
        }

        $data = $response->json();

        return [
            'checkout_id'     => $data['id'],
            'wave_launch_url' => $data['wave_launch_url'], // URL vers laquelle rediriger l'élève
        ];
    }

    // ──────────────────────────────────────────
    // VÉRIFIER LE STATUT D'UNE SESSION
    // ──────────────────────────────────────────

    /**
     * Vérifie le statut d'un checkout Wave (utile en fallback si webhook raté).
     */
    public function getCheckoutStatus(string $checkoutId): array
    {
        $response = Http::withToken($this->apiKey)
            ->get("{$this->baseUrl}/checkout/sessions/{$checkoutId}");

        if ($response->failed()) {
            Log::error('Wave API - Échec vérification checkout', [
                'checkout_id' => $checkoutId,
                'status'      => $response->status(),
            ]);
            throw new \Exception('Impossible de vérifier le statut du paiement.');
        }

        return $response->json();
    }

    // ──────────────────────────────────────────
    // VALIDER LA SIGNATURE DU WEBHOOK
    // ──────────────────────────────────────────

    /**
     * Vérifie que le webhook provient bien de Wave (HMAC SHA-256).
     *
     * Wave envoie la signature dans le header : 'wave-signature'
     * Format : t=<timestamp>,v1=<hmac>
     */
    public function verifyWebhookSignature(string $payload, string $signatureHeader): bool
    {
        $secret = config('services.wave.webhook_secret');

        if (empty($secret)) {
            Log::warning('Wave webhook_secret non configuré — validation ignorée.');
            return true; // En dev sans secret configuré
        }

        // Parser le header "t=1234567890,v1=abcdef..."
        $parts = [];
        foreach (explode(',', $signatureHeader) as $part) {
            [$key, $value] = explode('=', $part, 2);
            $parts[$key] = $value;
        }

        if (empty($parts['t']) || empty($parts['v1'])) {
            return false;
        }

        // Calculer le HMAC attendu
        $signedPayload = $parts['t'] . '.' . $payload;
        $expectedHmac  = hash_hmac('sha256', $signedPayload, $secret);

        return hash_equals($expectedHmac, $parts['v1']);
    }

    // ──────────────────────────────────────────
    // MAPPER LE STATUT WAVE → NOTRE STATUT
    // ──────────────────────────────────────────

    /**
     * Convertit le statut Wave en statut interne.
     * Wave statuses: pending, processing, succeeded, cancelled, failed
     */
    public function mapStatus(string $waveStatus): string
    {
        return match ($waveStatus) {
            'succeeded'  => 'completed',
            'cancelled'  => 'failed',
            'failed'     => 'failed',
            'processing' => 'pending',
            default      => 'pending',
        };
    }
}