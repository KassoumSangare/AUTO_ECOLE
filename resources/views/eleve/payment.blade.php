{{-- resources/views/eleve/payment.blade.php --}}
@extends('layouts.app')
@section('title', 'Paiement')
@section('page-title', 'Paiement de la formation')

@section('head')
<style>
.payment-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid var(--border);
        overflow: hidden;
    }
    .payment-hero {
        background: linear-gradient(135deg, var(--texte) 0%, var(--vert) 100%);
        padding: 2.5rem; color: #fff; position: relative; overflow: hidden;
    }
    .payment-hero::after {
        content: ''; position: absolute; right: -60px; top: -60px;
        width: 220px; height: 220px; border-radius: 50%;
        background: rgba(212,168,67,.12);
    }
    .amount-display { font-family: 'Syne',sans-serif; font-size: 3rem; font-weight: 900; color: var(--or); line-height: 1; }
    .amount-label { font-size: .85rem; color: rgba(255,255,255,.6); margin-top: .25rem; }
    .payment-body { padding: 2rem; }
    .avantage-item { display: flex; align-items: flex-start; gap: .75rem; padding: .75rem 0; border-bottom: 1px solid var(--bg); }
    .avantage-item:last-child { border-bottom: none; }
    .avantage-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .btn-wave { background: linear-gradient(135deg, #2D6A4F, #0D5FCC); border: none; color: #fff; font-family: 'Syne',sans-serif; font-weight: 800; font-size: 1.05rem; padding: 1rem 1.5rem; border-radius: 14px; width: 100%; transition: .25s ease; display: flex; align-items: center; justify-content: center; gap: .75rem; cursor: pointer; }
    .btn-wave:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(26,115,232,.4); }
    .wave-logo { background: #fff; border-radius: 8px; padding: 3px 8px; font-weight: 900; font-size: .9rem; color: #2D6A4F; }
    .security-note { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #9CA3AF; margin-top: .75rem; justify-content: center; }
    .paid-banner { background: linear-gradient(135deg, var(--vert), #20A169); border-radius: 16px; padding: 2rem; color: #fff; text-align: center; }
    .transaction-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid var(--bg); font-size: .88rem; }
    .transaction-row:last-child { border-bottom: none; }
</style>
@endsection

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-lg-7">

        @if($hasPaid)
        <div class="paid-banner mb-4">
            <i class="bi bi-patch-check-fill" style="font-size:2.5rem;"></i>
            <h4 class="mt-2" style="font-family:'Syne',sans-serif; font-weight:800;">Formation activée !</h4>
            <p style="opacity:.85; margin:.5rem 0 1.5rem;">Votre paiement a été confirmé. Vous avez accès à toutes les ressources.</p>
            <a href="{{ route('eleve.mediatheque') }}" class="btn btn-light fw-bold" style="border-radius:10px; color:var(--vert);">
                <i class="bi bi-play-circle-fill me-2"></i>Accéder à la médiathèque
            </a>
        </div>
        @endif

        <div class="payment-card">
            <div class="payment-hero">
                <div style="position:relative; z-index:1;">
                    <div style="font-size:.8rem; text-transform:uppercase; letter-spacing:.1em; opacity:.6; margin-bottom:.5rem;">Frais d'inscription</div>
                    <div class="amount-display">30 000</div>
                    <div class="amount-label">Francs CFA (XOF)</div>
                </div>
            </div>
            <div class="payment-body">
                <h6 style="font-family:'Syne',sans-serif; font-weight:800; margin-bottom:1rem;">Ce qui est inclus</h6>
                @php
                $avantages = [
                    ['bi-play-circle-fill', '#E8F4FF', 'var(--vert)', 'Médiathèque vidéo complète', 'Cours signalisation + conduite en vidéo HD'],
                    ['bi-patch-question-fill', '#FEFCE8', 'var(--or)', 'Quiz QCM illimités', 'Entraînez-vous autant que vous voulez'],
                    ['bi-folder2-open', '#E8FFE8', 'var(--vert)', 'Coffre-fort numérique', 'Dépôt sécurisé de vos pièces justificatives'],
                    ['bi-file-earmark-pdf-fill', '#FFE8F4', '#C2185B', 'Reçu PDF officiel', 'Généré automatiquement après paiement'],
                ];
                @endphp
                @foreach($avantages as [$icon, $bg, $color, $titre, $desc])
                <div class="avantage-item">
                    <div class="avantage-icon" style="background:{{ $bg }}; color:{{ $color }};"><i class="bi {{ $icon }}"></i></div>
                    <div>
                        <div style="font-weight:700; font-size:.9rem; color:var(--texte);">{{ $titre }}</div>
                        <div style="font-size:.8rem; color:#9CA3AF;">{{ $desc }}</div>
                    </div>
                </div>
                @endforeach
                <div class="mt-4">
                    @if(! $hasPaid)
                        @if(session('error') || request()->query('error'))
                        <div class="alert alert-danger mb-3" style="border-radius:10px; font-size:.88rem;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Le paiement a échoué. Veuillez réessayer ou contacter l'auto-école via WhatsApp.
                        </div>
                        @endif
                        <form method="POST" action="{{ route('eleve.payment.initiate') }}">
                            @csrf
                            <button type="submit" class="btn-wave" id="payBtn">
                                <span class="wave-logo">W</span>
                                Payer avec Wave
                                <i class="bi bi-arrow-right-circle-fill"></i>
                            </button>
                        </form>
                        <div class="security-note">
                            <i class="bi bi-shield-lock-fill" style="color:var(--vert);"></i>
                            Paiement 100% sécurisé via Wave CI
                        </div>
                    @else
                        <div class="text-center py-2">
                            <span class="badge" style="background:#E8FFE8; color:var(--vert); font-size:.85rem; padding:.5rem 1rem; border-radius:50px;">
                                <i class="bi bi-check-circle-fill me-1"></i> Paiement déjà effectué
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($lastPayment)
        <div class="payment-card mt-4">
            <div class="payment-body">
                <h6 style="font-family:'Syne',sans-serif; font-weight:800; margin-bottom:1rem;">
                    <i class="bi bi-clock-history me-2" style="color:var(--vert);"></i>Historique de paiement
                </h6>
                <div class="transaction-row"><span class="text-muted">N° de reçu</span><span class="fw-bold">{{ $lastPayment->receipt_number ?? '—' }}</span></div>
                <div class="transaction-row"><span class="text-muted">Référence Wave</span><span style="font-size:.8rem; font-family:monospace;">{{ $lastPayment->reference_wave }}</span></div>
                <div class="transaction-row"><span class="text-muted">Montant</span><span class="fw-bold">{{ $lastPayment->montant_formate }}</span></div>
                <div class="transaction-row"><span class="text-muted">Date</span><span>{{ $lastPayment->created_at->format('d/m/Y à H:i') }}</span></div>
                <div class="transaction-row">
                    <span class="text-muted">Statut</span>
                    @php $statusConfig = ['completed'=>['success','✅ Confirmé'],'pending'=>['warning','⏳ En attente'],'failed'=>['danger','❌ Échoué']]; [$sc,$sl] = $statusConfig[$lastPayment->status]??['secondary',$lastPayment->status]; @endphp
                    <span class="badge bg-{{ $sc }}">{{ $sl }}</span>
                </div>
                @if($lastPayment->status === 'completed')
                <div class="mt-3 text-center">
                    <a href="{{ route('eleve.payment.receipt', $lastPayment) }}" class="btn btn-sm" style="background:var(--texte); color:#fff; border-radius:8px; padding:.5rem 1.25rem;">
                        <i class="bi bi-file-earmark-pdf-fill me-2"></i>Télécharger mon reçu PDF
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelector('form')?.addEventListener('submit', function () {
    const btn = document.getElementById('payBtn');
    if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Redirection vers Wave...'; }
});
</script>
@endsection