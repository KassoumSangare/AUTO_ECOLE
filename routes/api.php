<?php

use App\Http\Controllers\Eleve\QuizController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth')->group(function () {
    Route::get('/quiz/questions', [QuizController::class, 'getQuestions']);
});

// ══════════════════════════════════════════════════════
//  WEBHOOKS WAVE
// ══════════════════════════════════════════════════════
Route::prefix('webhooks')->group(function () {
    Route::post('/wave', [WebhookController::class, 'handleWaveWebhook'])
        ->middleware('verify.wave.signature')
        ->name('webhooks.wave');
});

// ══════════════════════════════════════════════════════
//  ROUTES DE PAIEMENT
// ══════════════════════════════════════════════════════
Route::middleware(['auth'])->prefix('payment')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/success/{order}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/error/{order}', [PaymentController::class, 'error'])->name('payment.error');
    Route::get('/history', [PaymentController::class, 'history'])->name('payment.history');
    Route::get('/receipt/{order}', [PaymentController::class, 'downloadReceipt'])->name('payment.receipt');
    Route::get('/check-status/{order}', [PaymentController::class, 'checkStatus'])->name('payment.check-status');
});