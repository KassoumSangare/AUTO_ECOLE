@extends('layouts.app')
@section('title', 'Fiche Élève')
@section('page-title', 'Fiche Élève')

@section('head')
<style>
    .hero-fiche {
        background: linear-gradient(135deg, var(--rouge) 0%, var(--rouge-c) 100%);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .hero-fiche::before {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
    }

    .fiche-av {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .2);
        border: 3px solid rgba(255, 255, 255, .35);
        color: #fff;
        font-family: 'Syne', sans-serif;
        font-weight: 900;
        font-size: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .fiche-name {
        font-family: 'Syne', sans-serif;
        font-weight: 900;
        font-size: 1.35rem;
        color: #fff;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .fiche-sub {
        color: rgba(255, 255, 255, .75);
        font-size: .85rem;
        margin-top: .2rem;
        position: relative;
        z-index: 1;
    }

    .fiche-chip {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 50px;
        padding: .32rem .85rem;
        color: #fff;
        font-size: .76rem;
        font-weight: 700;
        margin-top: .5rem;
        position: relative;
        z-index: 1;
    }

    .pcard {
        background: #fff;
        border-radius: var(--r);
        border: 1.5px solid var(--border);
    }

    .pcard-h {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid var(--border);
    }

    .pcard-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .pcard-title {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .93rem;
        color: var(--texte);
        margin: 0;
    }

    .pcard-body {
        padding: 1.25rem 1.4rem;
    }

    .doc-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .65rem 0;
        border-bottom: 1px solid var(--bg);
    }

    .doc-row:last-child {
        border-bottom: none;
    }

    .quiz-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .6rem 0;
        border-bottom: 1px solid var(--bg);
    }

    .quiz-row:last-child {
        border-bottom: none;
    }

    .bs-val {
        background: var(--vert-p);
        color: var(--vert-c);
    }

    .bs-att {
        background: #FEFCE8;
        color: #78350F;
    }

    .bs-rej {
        background: var(--rouge-p);
        color: var(--rouge-c);
    }

    .badge-s {
        font-size: .7rem;
        padding: .25rem .6rem;
        border-radius: 50px;
        font-weight: 700;
    }

    .btn-back {
        background: var(--rouge);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: .65rem 1.4rem;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: .88rem;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        text-decoration: none;
        transition: .2s ease;
    }

    .btn-back:hover {
        background: var(--rouge-c);
        color: #fff;
        transform: translateX(-2px);
    }

    .btn-dl {
        background: var(--rouge-p);
        color: var(--rouge);
        border: none;
        border-radius: 7px;
        padding: .28rem .55rem;
        font-size: .75rem;
    }
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="hero-fiche">
    <div class="fiche-av">{{ strtoupper(substr($user->prenom,0,1)) }}</div>
    <div class="flex-grow-1">
        <h2 class="fiche-name">{{ strtoupper($user->nom) }} {{ $user->prenom }}</h2>
        <div class="fiche-sub">
            <i class="bi bi-telephone me-1"></i>{{ $user->telephone }}
            @if($user->email) &nbsp;·&nbsp;<i class="bi bi-envelope me-1"></i>{{ $user->email }} @endif
        </div>
        <div>
            @if($user->hasPaid())
            <span class="fiche-chip"><i class="bi bi-patch-check-fill" style="color:#4ADE80;"></i>Paiement confirmé</span>
            @else
            <span class="fiche-chip"><i class="bi bi-clock"></i>Paiement en attente</span>
            @endif
        </div>
    </div>
    <div style="text-align:right;position:relative;z-index:1;">
        <div style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:12px;padding:.75rem 1.1rem;">
            <div style="font-family:'Syne',sans-serif;font-size:1.3rem;font-weight:900;color:#fff;">{{ $user->created_at->format('d/m/Y') }}</div>
            <div style="font-size:.72rem;color:rgba(255,255,255,.65);">Inscrit le</div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Infos + paiements --}}
    <div class="col-lg-4">
        <div class="pcard mb-3">
            <div class="pcard-h">
                <div class="pcard-icon" style="background:var(--rouge-p);color:var(--rouge);"><i class="bi bi-person-fill"></i></div>
                <h3 class="pcard-title">Informations</h3>
            </div>
            <div class="pcard-body">
                @foreach([['Nom complet', $user->nom_complet], ['Téléphone', $user->telephone], ['Email', $user->email ?? '—'], ['Rôle', ucfirst($user->role)], ['Statut', $user->is_active ? 'Actif' : 'Inactif']] as [$lbl, $val])
                <div class="d-flex justify-content-between py-2 border-bottom" style="font-size:.85rem;">
                    <span style="color:var(--texte-2);font-weight:500;">{{ $lbl }}</span>
                    <span style="font-weight:700;color:var(--texte);">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="pcard">
            <div class="pcard-h">
                <div class="pcard-icon" style="background:var(--vert-p);color:var(--vert);"><i class="bi bi-credit-card-fill"></i></div>
                <h3 class="pcard-title">Paiements</h3>
            </div>
            <div class="pcard-body">
                @forelse($user->payments as $p)
                <div class="doc-row">
                    <div>
                        <div style="font-weight:700;font-size:.85rem;">{{ $p->receipt_number ?? '—' }}</div>
                        <div style="font-size:.73rem;color:#9CA3AF;">{{ $p->created_at->format('d/m/Y') }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:.88rem;">{{ $p->montant_formate }}</div>
                        <span class="badge-s {{ $p->status==='completed'?'bs-val':($p->status==='pending'?'bs-att':'bs-rej') }}">
                            {{ ['completed'=>'✅ Payé','pending'=>'⏳ En attente','failed'=>'❌ Échoué'][$p->status] ?? $p->status }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-center py-3" style="font-size:.85rem;color:#9CA3AF;">Aucun paiement.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Documents --}}
    <div class="col-lg-4">
        <div class="pcard h-100">
            <div class="pcard-h">
                <div class="pcard-icon" style="background:var(--rouge-p);color:var(--rouge);"><i class="bi bi-folder2-open"></i></div>
                <h3 class="pcard-title">Documents <span style="font-size:.75rem;color:#9CA3AF;font-weight:400;">({{ $user->documents->count() }})</span></h3>
            </div>
            <div class="pcard-body">
                @forelse($user->documents as $doc)
                <div class="doc-row">
                    <div>
                        <div style="font-weight:700;font-size:.84rem;color:var(--texte);">{{ $doc->label_type }}</div>
                        <div style="font-size:.73rem;color:#9CA3AF;">{{ $doc->size_formate }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge-s {{ ['en_attente'=>'bs-att','valide'=>'bs-val','rejete'=>'bs-rej'][$doc->status] }}">
                            {{ ucfirst($doc->status) }}
                        </span>
                        <a href="{{ route('admin.documents.download', $doc) }}" class="btn btn-dl">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-center py-4" style="font-size:.85rem;color:#9CA3AF;">
                    <i class="bi bi-folder-x" style="font-size:1.8rem;display:block;margin-bottom:.4rem;"></i>
                    Aucun document déposé.
                </p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Quiz --}}
    <div class="col-lg-4">
        <div class="pcard h-100">
            <div class="pcard-h">
                <div class="pcard-icon" style="background:var(--vert-p);color:var(--vert);"><i class="bi bi-patch-question-fill"></i></div>
                <h3 class="pcard-title">Quiz <span style="font-size:.75rem;color:#9CA3AF;font-weight:400;">({{ $user->quizScores->count() }})</span></h3>
            </div>
            <div class="pcard-body">
                @forelse($user->quizScores->sortByDesc('created_at') as $s)
                <div class="quiz-row">
                    <div>
                        <span class="badge-s" style="background:{{ $s->category==='code'?'var(--rouge-p)':'var(--vert-p)' }};color:{{ $s->category==='code'?'var(--rouge-c)':'var(--vert-c)' }};">
                            {{ ucfirst($s->category) }}
                        </span>
                        <span style="font-size:.73rem;color:#9CA3AF;margin-left:.5rem;">{{ $s->created_at->format('d/m/Y') }}</span>
                    </div>
                    <strong style="color:{{ $s->is_reussi?'var(--vert)':'var(--rouge)' }};font-family:'Syne',sans-serif;font-size:.88rem;">
                        {{ $s->score }}/{{ $s->total_questions }}
                        <small style="font-size:.7rem;">({{ number_format($s->percentage,0) }}%)</small>
                    </strong>
                </div>
                @empty
                <p class="text-center py-4" style="font-size:.85rem;color:#9CA3AF;">
                    <i class="bi bi-patch-question" style="font-size:1.8rem;display:block;margin-bottom:.4rem;"></i>
                    Aucun quiz effectué.
                </p>
                @endforelse
            </div>
        </div>
    </div>

</div>

<div class="mt-3">
    <a href="{{ route('admin.eleves.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i>Retour à la liste
    </a>
</div>
@endsection