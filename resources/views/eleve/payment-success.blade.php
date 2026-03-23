{{-- resources/views/eleve/payment-success.blade.php --}}
@extends('layouts.app')
@section('title', 'Paiement confirmé')
@section('page-title', 'Confirmation de paiement')

@section('head')
<style>
    :root {
        --rouge: #AF2636;
        --rouge-c: #8A1E2B;
        --rouge-p: #FFF1F2;
        --vert: #2D6A4F;
        --vert-c: #1B4332;
        --vert-p: #F0F7F4;
        --or: #C5A059;
        --or-c: #D9B36A;
        --texte: #1F2937;
        --texte-2: #6B7280;
        --border: #E5E7EB;
        --bg: #F5F5F3;
        --font-d: 'Syne', Georgia, serif;
        --font-b: 'DM Sans', 'Helvetica Neue', Arial, sans-serif;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">

        <div style="background:#fff; border-radius:20px; padding:3rem 2rem; border:1.5px solid var(--border);">

            @if($payment->status === 'completed')
            {{-- Succès --}}
            <div style="width:80px;height:80px;background:var(--vert-p);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:2.2rem;color:var(--vert);">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h3 style="font-family:var(--font-d);font-weight:800;color:var(--texte);">Paiement confirmé !</h3>
            <p class="text-muted mt-2 mb-3">Votre formation est maintenant activée. Bienvenue dans votre espace élève.</p>

            <div style="background:var(--bg);border-radius:12px;padding:1rem 1.5rem;text-align:left;margin-bottom:1.5rem;">
                <div style="display:flex;justify-content:space-between;padding:.4rem 0;font-size:.88rem;">
                    <span class="text-muted">Reçu N°</span>
                    <strong>{{ $payment->receipt_number }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;padding:.4rem 0;font-size:.88rem;">
                    <span class="text-muted">Montant</span>
                    <strong>{{ $payment->montant_formate }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;padding:.4rem 0;font-size:.88rem;">
                    <span class="text-muted">Date</span>
                    <strong>{{ $payment->paid_at?->format('d/m/Y à H:i') }}</strong>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-center flex-wrap">
                <a href="{{ route('eleve.payment.receipt', $payment) }}" class="btn" style="background:var(--rouge);color:#fff;border-radius:10px;font-weight:700;padding:.7rem 1.5rem;">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>Télécharger le reçu
                </a>
                <a href="{{ route('eleve.mediatheque') }}" class="btn" style="background:#D4A843;color:var(--texte);border-radius:10px;font-weight:700;padding:.7rem 1.5rem;">
                    <i class="bi bi-play-circle-fill me-2"></i>Commencer la formation
                </a>
            </div>

            @else
            {{-- En attente --}}
            <div style="width:80px;height:80px;background:#FEFCE8;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:2.2rem;color:var(--or);">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <h3 style="font-family:var(--font-d);font-weight:800;color:var(--texte);">Paiement en cours de vérification</h3>
            <p class="text-muted mt-2 mb-3">Votre paiement est en cours de traitement. Rafraîchissez dans quelques instants.</p>
            <a href="{{ route('eleve.payment') }}" class="btn" style="background:var(--rouge);color:#fff;border-radius:10px;font-weight:700;">
                <i class="bi bi-arrow-clockwise me-2"></i>Vérifier le statut
            </a>
            @endif

        </div>
    </div>
</div>
@endsection