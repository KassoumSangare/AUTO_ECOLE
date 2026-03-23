<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Eleve\DashboardController;
use App\Http\Controllers\Eleve\MediathequeController;
use App\Http\Controllers\Eleve\QuizController;
use App\Http\Controllers\Eleve\DocumentController;
use App\Http\Controllers\Eleve\PaymentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EleveController;
use App\Http\Controllers\Admin\AdminDocumentController;
use App\Http\Controllers\Admin\ReportingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════
//  ROUTES PUBLIQUES
// ══════════════════════════════════════════════════════

Route::get('/', [HomeController::class, 'index'])->name('home');

// ──────────────────────────────────────────
//  AUTHENTIFICATION (invités seulement)
// ──────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/inscription',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/inscription', [AuthController::class, 'register']);

    Route::get('/connexion',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/connexion',   [AuthController::class, 'login']);
});

Route::post('/deconnexion', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ══════════════════════════════════════════════════════
//  ESPACE ÉLÈVE (auth requis)
// ══════════════════════════════════════════════════════

Route::middleware(['auth'])->prefix('espace-eleve')->name('eleve.')->group(function () {

    // Dashboard (accessible sans paiement)
    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');

    // Tunnel de paiement (accessible sans paiement, pour payer justement)
    Route::get('/paiement',              [PaymentController::class, 'index'])->name('payment');
    Route::post('/paiement/initier',     [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/paiement/succes',       [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/recu/{payment}',        [PaymentController::class, 'downloadReceipt'])->name('payment.receipt');

    // Webhook Wave (pas de middleware auth — appelé par le serveur Wave)
    // Note: Ce webhook est déclaré en dehors du groupe auth ci-dessous

    // ── Accès subordonné au paiement ──────────────
    // Route::middleware('paid')->group(function () {
    //     Route::get('/mediatheque',          [MediathequeController::class, 'index'])->name('mediatheque');
    //     Route::get('/quiz',                 [QuizController::class, 'index'])->name('quiz');
    //     Route::post('/quiz/score',          [QuizController::class, 'storeScore'])->name('quiz.store');
    //     Route::get('/documents',            [DocumentController::class, 'index'])->name('documents');
    //     Route::post('/documents',           [DocumentController::class, 'store'])->name('documents.store');
    //     Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    // });

     Route::get('/mediatheque',          [MediathequeController::class, 'index'])->name('mediatheque');
    Route::get('/quiz',                 [QuizController::class, 'index'])->name('quiz');
    Route::post('/quiz/score',          [QuizController::class, 'storeScore'])->name('quiz.store');
    Route::get('/documents',            [DocumentController::class, 'index'])->name('documents');
    Route::post('/documents',           [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/{document}/telecharger', [DocumentController::class, 'download'])->name('documents.download');

    // ── Téléchargement document (sans middleware paid — accessible depuis profil) ──
    Route::get('/documents/{document}/telecharger', [DocumentController::class, 'download'])->name('documents.download');
});

// Webhook Wave (hors auth — requête serveur externe)
Route::post('/webhook/wave', [PaymentController::class, 'webhook'])
    ->name('webhook.wave')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// ══════════════════════════════════════════════════════
//  BACK-OFFICE ADMIN
// ══════════════════════════════════════════════════════

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord',          [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRM Élèves
    Route::get('/eleves',                   [EleveController::class, 'index'])->name('eleves.index');
    Route::get('/eleves/export',            [EleveController::class, 'export'])->name('eleves.export');
    Route::get('/eleves/{user}',            [EleveController::class, 'show'])->name('eleves.show');

    // Gestion documents
    Route::get('/documents',                [AdminDocumentController::class, 'index'])->name('documents.index');
    Route::patch('/documents/{document}',   [AdminDocumentController::class, 'updateStatus'])->name('documents.status');
    Route::get('/documents/impression',     [AdminDocumentController::class, 'printAll'])->name('documents.print');

    // Reporting financier
    Route::get('/reporting',                [ReportingController::class, 'index'])->name('reporting.index');
    Route::get('/reporting/export',         [ReportingController::class, 'exportExcel'])->name('reporting.export');
});

// ══════════════════════════════════════════════════════
//  API INTERNES (JSON — appelées par Fetch/AJAX)
// ══════════════════════════════════════════════════════

Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::get('/quiz/questions', [QuizController::class, 'getQuestions'])->name('quiz.questions');
    Route::post('/quiz/score',    [QuizController::class, 'storeScore'])->name('quiz.score');
});

// Route téléchargement document admin (hors groupe pour le binding)
Route::middleware(['auth','admin'])
    ->get('/admin/documents/{document}/download', [AdminDocumentController::class, 'download'])
    ->name('admin.documents.download');

Route::middleware(['auth','admin'])
    ->get('/admin/documents/impression', [AdminDocumentController::class, 'printAll'])
    ->name('admin.documents.print');

// ── Profil élève ──────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/espace-eleve/profil',           [\App\Http\Controllers\Eleve\ProfileController::class, 'index'])->name('eleve.profile');
    Route::patch('/espace-eleve/profil',         [\App\Http\Controllers\Eleve\ProfileController::class, 'update'])->name('eleve.profile.update');
    Route::patch('/espace-eleve/profil/password',[\App\Http\Controllers\Eleve\ProfileController::class, 'updatePassword'])->name('eleve.profile.password');
    // Route documents.download → définie dans le groupe eleve. (eleve.documents.download)
});