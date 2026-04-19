<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasPaid
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Paiement Wave valide OU approbation manuelle admin
        if (!$user || !$user->hasPremiumAccess()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Accès refusé. Un paiement est requis ou votre demande d\'approbation est en attente.'
                ], 403);
            }

            return redirect()->route('eleve.payment')
                ->with('warning', 'Veuillez effectuer votre paiement ou attendre l\'approbation de votre demande pour accéder à cette section.');
        }

        return $next($request);
    }
}