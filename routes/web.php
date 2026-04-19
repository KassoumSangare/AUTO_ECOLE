<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDocumentController;
use App\Http\Controllers\Admin\EleveController;
use App\Http\Controllers\Admin\PermitCategoryController;
use App\Http\Controllers\Admin\ReportingController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Eleve\DashboardController;
use App\Http\Controllers\Eleve\DocumentController;
use App\Http\Controllers\Eleve\MediathequeController;
use App\Http\Controllers\Eleve\PaymentController;
use App\Http\Controllers\Eleve\ProfileController as EleveProfileController;
use App\Http\Controllers\Eleve\QuizController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

// ══════════════════════════════════════════════════════
//  ROUTES PUBLIQUES
// ══════════════════════════════════════════════════════
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/categories/{code}', [HomeController::class, 'getCategory'])->name('api.category.show');

// ──────────────────────────────────────────
//  AUTHENTIFICATION
// ──────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/inscription', [AuthController::class, 'register']);

    Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/connexion', [AuthController::class, 'login']);
});

Route::post('/deconnexion', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ══════════════════════════════════════════════════════
//  WEBHOOK WAVE (Hors Auth et CSRF)
// ══════════════════════════════════════════════════════
Route::post('/webhook/wave', [PaymentController::class, 'webhook'])
    ->name('webhook.wave')
    ->withoutMiddleware([VerifyCsrfToken::class]);


// ══════════════════════════════════════════════════════
//  ESPACE ÉLÈVE (auth requis)
// ══════════════════════════════════════════════════════
Route::middleware(['auth'])->prefix('espace-eleve')->name('eleve.')->group(function () {

    // ── Accessible sans paiement ──────────────────────
    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/paiement', [PaymentController::class, 'index'])->name('payment');
    Route::post('/paiement/initier', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/paiement/succes', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/recu/{payment}', [PaymentController::class, 'downloadReceipt'])->name('payment.receipt');
    Route::get('/profil', [EleveProfileController::class, 'index'])->name('profile');
    Route::patch('/profil', [EleveProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profil/password', [EleveProfileController::class, 'updatePassword'])->name('profile.password');

    // ── Accès Premium (paiement Wave OU approbation manuelle admin) ──
    Route::middleware(['paid'])->group(function () {
        Route::get('/mediatheque', [MediathequeController::class, 'index'])->name('mediatheque');
        Route::get('/quiz', [QuizController::class, 'index'])->name('quiz');
        Route::get('/quiz/questions', [QuizController::class, 'getQuestions'])->name('quiz.questions');
        Route::post('/quiz/score', [QuizController::class, 'storeScore'])->name('quiz.store');
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{document}/telecharger', [DocumentController::class, 'download'])->name('documents.download');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    });
});

// Ancien groupe de paiement
Route::middleware(['auth'])->prefix('payment')->group(function () {
    Route::get('/history', [PaymentController::class, 'history'])->name('payment.history');
    Route::get('/check-status/{order}', [PaymentController::class, 'checkStatus'])->name('payment.check-status');
    Route::get('/error/{order}', [PaymentController::class, 'error'])->name('payment.error');
});


// ══════════════════════════════════════════════════════
//  BACK-OFFICE ADMIN (auth + admin)
// ══════════════════════════════════════════════════════
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/tableau-de-bord', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestion des paiements (Admin)
    Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments.index');
    Route::get('/payments/export', [AdminDashboardController::class, 'exportPayments'])->name('payments.export');
    Route::get('/payments/{order}', [AdminDashboardController::class, 'paymentDetails'])->name('payments.show');
    Route::post('/payments/{order}/resend-receipt', [AdminDashboardController::class, 'resendReceipt'])->name('payments.resend');
    Route::post('/payments/{order}/mark-succeeded', [AdminDashboardController::class, 'markAsSucceeded'])->name('payments.mark-succeeded');

    // CRM Élèves
    Route::get('/eleves', [EleveController::class, 'index'])->name('eleves.index');
    Route::get('/eleves/export', [EleveController::class, 'export'])->name('eleves.export');
    Route::get('/eleves/{user}', [EleveController::class, 'show'])->name('eleves.show');
    Route::patch('/eleves/{user}/toggle-acces', [EleveController::class, 'toggleManualApproval'])->name('eleves.toggle-acces'); // ← NOUVEAU

    // Gestion documents
    Route::get('/documents', [AdminDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/impression', [AdminDocumentController::class, 'printAll'])->name('documents.print');
    Route::get('/documents/{document}/download', [AdminDocumentController::class, 'download'])->name('documents.download');
    Route::patch('/documents/{document}', [AdminDocumentController::class, 'updateStatus'])->name('documents.status');

    // Reporting financier
    Route::get('/reporting', [ReportingController::class, 'index'])->name('reporting.index');
    Route::get('/reporting/export', [ReportingController::class, 'exportExcel'])->name('reporting.export');

    // Catégories de permis
    Route::resource('permit-categories', PermitCategoryController::class);
    Route::post('permit-categories/{permitCategory}/toggle-active', [PermitCategoryController::class, 'toggleActive'])->name('permit-categories.toggle-active');
});

// ──────────────────────────────────────────
//  PROFIL ADMIN
// ──────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});


// ══════════════════════════════════════════════════════
//  API INTERNES (JSON — appelées par Fetch/AJAX)
// ══════════════════════════════════════════════════════
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::get('/quiz/questions', [QuizController::class, 'getQuestions'])->name('quiz.questions');
    Route::post('/quiz/score', [QuizController::class, 'storeScore'])->name('quiz.score');
});