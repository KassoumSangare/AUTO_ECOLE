<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Gère une requête entrante.
     * * Vérifie que l'utilisateur connecté possède le rôle 'admin'.
     * Si ce n'est pas le cas, redirige vers le dashboard avec un message d'erreur.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier que l'utilisateur est connecté ET qu'il est admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Accès non autorisé. Vous n\'avez pas les permissions administrateur.');
        }

        return $next($request);
    }
}
