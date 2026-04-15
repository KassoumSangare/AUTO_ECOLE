<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // ── Enregistrement des alias ──
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureIsAdmin::class,
            'paid'  => \App\Http\Middleware\EnsureHasPaid::class,
        ]);

        // ── Exclusion CSRF ──
        $middleware->validateCsrfTokens(except: [
            'webhook/wave',
        ]);
        $middleware->alias([
            'verify.wave.signature' => \App\Http\Middleware\VerifyWaveSignature::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
