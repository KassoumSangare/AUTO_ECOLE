@extends('layouts.app')
@section('title', 'Mon tableau de bord')
@section('page-title', 'Tableau de bord')

@section('head')
<style>
.kstat { background:#fff; border-radius:var(--r); padding:1.4rem; border:1.5px solid var(--border); transition:.25s ease; }
.kstat:hover { box-shadow:0 8px 28px rgba(0,0,0,.08); transform:translateY(-3px); }
.kstat .ico { width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin-bottom:1rem; }
.kstat .val { font-family:'Syne',sans-serif;font-size:1.8rem;font-weight:800;color:var(--texte); }
.kstat .lbl { font-size:.82rem;color:var(--texte-2);font-weight:500; }

.prog-bar { height:8px;border-radius:50px;background:var(--border);overflow:hidden; }
.prog-fill { height:100%;border-radius:50px;transition:width .8s ease .3s; }

.payment-banner {
    background:linear-gradient(135deg,var(--rouge),var(--rouge-c));
    border-radius:var(--r); padding:2rem; color:#fff; position:relative; overflow:hidden;
}
.payment-banner::after { content:''; position:absolute; right:-40px;top:-40px; width:180px;height:180px; border-radius:50%; background:rgba(255,255,255,.08); }

.score-row { display:flex;align-items:center;justify-content:space-between;padding:.65rem 0;border-bottom:1px solid var(--bg); }
.score-row:last-child { border-bottom:none; }
</style>
@endsection

@section('content')

@if(! $stats['has_paid'])
<div class="payment-banner mb-4">
    <div style="position:relative;z-index:1;">
        <h5 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:.5rem;">
            <i class="bi bi-credit-card me-2" style="color:rgba(255,255,255,.8);"></i>Activez votre formation
        </h5>
        <p style="opacity:.82;font-size:.9rem;margin-bottom:1rem;">Effectuez votre paiement pour accéder aux vidéos, quiz et au coffre numérique.</p>
        <a href="{{ route('eleve.payment') }}" class="btn fw-bold" style="background:#fff;color:var(--rouge);border-radius:10px;">
            <i class="bi bi-credit-card-fill me-2"></i>Payer maintenant
        </a>
    </div>
</div>
@endif

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="kstat">
            <div class="ico" style="background:var(--rouge-p);color:var(--rouge);"><i class="bi bi-folder2-open"></i></div>
            <div class="val">{{ $stats['documents'] }}</div>
            <div class="lbl">Documents déposés</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="kstat">
            <div class="ico" style="background:var(--rouge-p);color:var(--rouge);"><i class="bi bi-patch-question-fill"></i></div>
            <div class="val">{{ number_format($stats['quiz_code'],0) }}%</div>
            <div class="lbl">Moy. Quiz Code</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="kstat">
            <div class="ico" style="background:var(--vert-p);color:var(--vert);"><i class="bi bi-steering2"></i></div>
            <div class="val">{{ number_format($stats['quiz_cond'],0) }}%</div>
            <div class="lbl">Moy. Quiz Conduite</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="kstat">
            <div class="ico" style="background:{{ $stats['has_paid']?'var(--vert-p)':'var(--rouge-p)' }};color:{{ $stats['has_paid']?'var(--vert)':'var(--rouge)' }};">
                <i class="bi bi-{{ $stats['has_paid']?'patch-check-fill':'clock' }}"></i>
            </div>
            <div class="val" style="font-size:1.1rem;padding-top:.4rem;">{{ $stats['has_paid']?'Actif':'En attente' }}</div>
            <div class="lbl">Statut paiement</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="kstat">
            <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1.25rem;">
                <i class="bi bi-graph-up me-2" style="color:var(--rouge);"></i>Ma progression
            </h6>
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <small style="font-weight:700;">Code de la route</small>
                    <small>{{ number_format($stats['quiz_code'],0) }}%</small>
                </div>
                <div class="prog-bar">
                    <div class="prog-fill" style="width:0%;background:var(--rouge);" data-width="{{ $stats['quiz_code'] }}"></div>
                </div>
            </div>
            <div>
                <div class="d-flex justify-content-between mb-1">
                    <small style="font-weight:700;">Conduite</small>
                    <small>{{ number_format($stats['quiz_cond'],0) }}%</small>
                </div>
                <div class="prog-bar">
                    <div class="prog-fill" style="width:0%;background:var(--vert);" data-width="{{ $stats['quiz_cond'] }}"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="kstat">
            <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1.25rem;">
                <i class="bi bi-clock-history me-2" style="color:var(--vert);"></i>Derniers quiz
            </h6>
            @forelse($stats['last_scores'] as $score)
            <div class="score-row">
                <div>
                    <span class="badge" style="background:{{ $score->category==='code'?'var(--rouge-p)':'var(--vert-p)' }};color:{{ $score->category==='code'?'var(--rouge-c)':'var(--vert-c)' }};font-size:.75rem;">
                        {{ ucfirst($score->category) }}
                    </span>
                    <small class="text-muted ms-2">{{ $score->created_at->diffForHumans() }}</small>
                </div>
                <div class="fw-bold" style="color:{{ $score->is_reussi?'var(--vert)':'var(--rouge)' }};font-family:'Syne',sans-serif;">
                    {{ $score->score }}/{{ $score->total_questions }}
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-3" style="font-size:.88rem;">
                <i class="bi bi-info-circle me-1"></i>Aucun quiz effectué pour l'instant.
            </p>
            @endforelse
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
document.querySelectorAll('.prog-fill').forEach(el => {
    const w = el.dataset.width;
    setTimeout(() => { el.style.width = w + '%'; }, 300);
});
</script>
@endsection