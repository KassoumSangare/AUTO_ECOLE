<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyWaveSignature
{
    /**
     * Vérifier la signature HMAC-SHA256 du webhook Wave
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'en-tête de signature
        $signature = $request->header('Wave-Signature');
        $secret = config('services.wave.webhook_secret');

        if (!$signature || !$secret) {
            Log::warning('Wave Webhook - Signature ou secret manquant');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Récupérer le corps brut de la requête
        $payload = $request->getContent();

        // Calculer la signature attendue
        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        // Comparer les signatures (utiliser hash_equals pour éviter les timing attacks)
        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Wave Webhook - Signature invalide', [
                'provided' => $signature,
                'expected' => $expectedSignature,
                'ip' => $request->ip(),
            ]);
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        Log::info('Wave Webhook - Signature valide');
        return $next($request);
    }
}
