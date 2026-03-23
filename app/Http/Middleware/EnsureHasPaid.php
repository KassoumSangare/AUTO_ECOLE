<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasPaid
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()->hasPaid()) {
            return redirect()->route('eleve.dashboard')
                ->with('warning', 'Accès réservé aux élèves ayant effectué leur paiement.');
        }

        return $next($request);
    }
}