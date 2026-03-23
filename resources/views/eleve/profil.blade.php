@extends('layouts.app')
@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')

@section('head')
<style>
    /* ═══ CARTE PROFIL ═══════════════════════════════════════ */
    .profile-hero {
        background: linear-gradient(135deg, var(--rouge) 0%, var(--rouge-c) 100%);
        border-radius: 20px;
        padding: 2rem 2.25rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.75rem;
        position: relative;
        overflow: hidden;
    }

    .profile-hero::before {
        content: '';
        position: absolute;
        right: -50px;
        top: -50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .2);
        border: 3px solid rgba(255, 255, 255, .4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Syne', sans-serif;
        font-weight: 900;
        font-size: 2rem;
        color: #fff;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .profile-hero-info {
        flex: 1;
        position: relative;
        z-index: 1;
    }

    .profile-hero-name {
        font-family: 'Syne', sans-serif;
        font-weight: 900;
        font-size: 1.5rem;
        color: #fff;
        margin: 0;
    }

    .profile-hero-sub {
        color: rgba(255, 255, 255, .78);
        font-size: .88rem;
        margin-top: .2rem;
    }

    .profile-status {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 50px;
        padding: .35rem .85rem;
        color: #fff;
        font-size: .78rem;
        font-weight: 700;
        margin-top: .5rem;
    }

    /* ═══ CARDS ══════════════════════════════════════════════ */
    .pcard {
        background: #fff;
        border-radius: var(--r);
        border: 1.5px solid var(--border);
    }

    .pcard-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid var(--border);
    }

    .pcard-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .pcard-title {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .95rem;
        color: var(--texte);
        margin: 0;
    }

    .pcard-body {
        padding: 1.4rem;
    }

    /* ═══ STATS MINI ══════════════════════════════════════════ */
    .stat-mini-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .75rem;
    }

    .stat-mini-card {
        background: var(--bg);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        border: 1.5px solid var(--border);
        transition: var(--trans);
    }

    .stat-mini-card:hover {
        border-color: var(--rouge);
        transform: translateY(-2px);
    }

    .stat-mini-val {
        font-family: 'Syne', sans-serif;
        font-weight: 900;
        font-size: 1.4rem;
        color: var(--texte);
        display: block;
    }

    .stat-mini-lbl {
        font-size: .72rem;
        color: var(--texte-2);
        margin-top: .15rem;
        display: block;
    }

    /* Barres progression */
    .prog-bar {
        height: 8px;
        background: var(--border);
        border-radius: 4px;
        overflow: hidden;
        margin-top: .35rem;
    }

    .prog-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 1s ease .3s;
    }

    /* ═══ FORMULAIRES ════════════════════════════════════════ */
    .form-label-lc {
        font-size: .82rem;
        font-weight: 700;
        color: var(--texte);
        margin-bottom: .35rem;
    }

    .form-control-lc {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: .7rem 1rem;
        font-size: .9rem;
        transition: border-color .2s, box-shadow .2s;
        width: 100%;
    }

    .form-control-lc:focus {
        outline: none;
        border-color: var(--rouge);
        box-shadow: 0 0 0 3px rgba(200, 16, 46, .12);
    }

    .form-control-lc.disabled {
        background: var(--bg);
        color: var(--texte-2);
        cursor: not-allowed;
    }

    .btn-save {
        background: var(--rouge);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: .7rem 1.5rem;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .9rem;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        transition: var(--trans);
        cursor: pointer;
    }

    .btn-save:hover {
        background: var(--rouge-c);
        transform: translateY(-1px);
    }

    .btn-save-vert {
        background: var(--vert);
    }

    .btn-save-vert:hover {
        background: var(--vert-c);
    }

    /* Indicateur force mdp */
    .pw-strength {
        height: 4px;
        border-radius: 2px;
        background: var(--border);
        margin-top: .4rem;
        overflow: hidden;
    }

    .pw-strength-bar {
        height: 100%;
        border-radius: 2px;
        width: 0;
        transition: .3s ease;
    }
</style>
@endsection

@section('content')

{{-- ══ HERO PROFIL ══ --}}
<div class="profile-hero">
    <div class="profile-avatar">{{ strtoupper(substr($user->prenom, 0, 1)) }}</div>
    <div class="profile-hero-info">
        <h2 class="profile-hero-name">{{ strtoupper($user->nom) }} {{ $user->prenom }}</h2>
        <div class="profile-hero-sub">
            <i class="bi bi-telephone me-1"></i>{{ $user->telephone }}
            @if($user->email)
            &nbsp;·&nbsp;<i class="bi bi-envelope me-1"></i>{{ $user->email }}
            @endif
        </div>
        <div class="profile-status">
            @if($stats['a_paye'])
            <i class="bi bi-patch-check-fill" style="color:#4ADE80;"></i> Formation activée
            @else
            <i class="bi bi-clock"></i> Paiement en attente
            @endif
        </div>
    </div>
    <div style="position:relative;z-index:1;">
        <div style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:12px;padding:.85rem 1.1rem;text-align:center;">
            <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:900;color:#fff;">{{ $user->created_at->format('Y') }}</div>
            <div style="font-size:.72rem;color:rgba(255,255,255,.7);">Membre depuis</div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- ── Colonne gauche ── --}}
    <div class="col-lg-4">

        {{-- Stats résumées --}}
        <div class="pcard mb-3">
            <div class="pcard-header">
                <div class="pcard-icon" style="background:var(--rouge-p);color:var(--rouge);"><i class="bi bi-graph-up-arrow"></i></div>
                <h3 class="pcard-title">Ma progression</h3>
            </div>
            <div class="pcard-body">
                <div class="stat-mini-grid mb-3">
                    <div class="stat-mini-card">
                        <span class="stat-mini-val">{{ $stats['quiz_total'] }}</span>
                        <span class="stat-mini-lbl">Quiz passés</span>
                    </div>
                    <div class="stat-mini-card">
                        <span class="stat-mini-val" style="color:var(--vert);">{{ $stats['quiz_reussis'] }}</span>
                        <span class="stat-mini-lbl">Réussis</span>
                    </div>
                    <div class="stat-mini-card">
                        <span class="stat-mini-val">{{ $stats['docs_valides'] }}/{{ $stats['docs_total'] }}</span>
                        <span class="stat-mini-lbl">Docs validés</span>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:.8rem;font-weight:700;color:var(--texte);">Code de la route</span>
                        <span style="font-size:.8rem;color:var(--texte-2);">{{ number_format($stats['moy_code'],0) }}%</span>
                    </div>
                    <div class="prog-bar">
                        <div class="prog-bar-fill" style="width:{{ $stats['moy_code'] }}%;background:var(--rouge);"></div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:.8rem;font-weight:700;color:var(--texte);">Conduite</span>
                        <span style="font-size:.8rem;color:var(--texte-2);">{{ number_format($stats['moy_conduite'],0) }}%</span>
                    </div>
                    <div class="prog-bar">
                        <div class="prog-bar-fill" style="width:{{ $stats['moy_conduite'] }}%;background:var(--vert);"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Historique paiements --}}
        <div class="pcard">
            <div class="pcard-header">
                <div class="pcard-icon" style="background:var(--vert-p);color:var(--vert);"><i class="bi bi-credit-card-fill"></i></div>
                <h3 class="pcard-title">Paiements</h3>
            </div>
            <div class="pcard-body">
                @forelse($user->payments as $payment)
                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                    <div>
                        <div style="font-weight:700;font-size:.85rem;">{{ $payment->receipt_number ?? '—' }}</div>
                        <div style="font-size:.75rem;color:var(--texte-2);">{{ $payment->created_at->format('d/m/Y') }}</div>
                    </div>
                    <div class="text-end">
                        <div style="font-family:'Syne',sans-serif;font-weight:900;font-size:.9rem;color:var(--texte);">{{ $payment->montant_formate }}</div>
                        @if($payment->status === 'completed')
                        @if($payment->receipt_path)
                        <a href="{{ route('eleve.payment.receipt', $payment) }}"
                            style="font-size:.72rem;color:var(--rouge);font-weight:600;text-decoration:none;">
                            <i class="bi bi-file-pdf-fill me-1"></i>Reçu PDF
                        </a>
                        @endif
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-center py-3" style="font-size:.85rem;color:var(--texte-2);">Aucun paiement enregistré.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ── Colonne droite ── --}}
    <div class="col-lg-8">

        {{-- Modifier les infos --}}
        <div class="pcard mb-3">
            <div class="pcard-header">
                <div class="pcard-icon" style="background:var(--rouge-p);color:var(--rouge);"><i class="bi bi-person-fill"></i></div>
                <h3 class="pcard-title">Mes informations personnelles</h3>
            </div>
            <div class="pcard-body">

                @if(session('success'))
                <div class="alert alert-success mb-3" style="border-radius:10px;font-size:.88rem;">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('eleve.profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label-lc">Nom</label>
                            <input type="text" name="nom" value="{{ old('nom', $user->nom) }}"
                                class="form-control-lc @error('nom') border-danger @enderror">
                            @error('nom') <div style="font-size:.78rem;color:var(--rouge);margin-top:.25rem;">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-lc">Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}"
                                class="form-control-lc @error('prenom') border-danger @enderror">
                            @error('prenom') <div style="font-size:.78rem;color:var(--rouge);margin-top:.25rem;">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-lc">Téléphone <span style="font-size:.72rem;color:var(--texte-2);">(identifiant — non modifiable)</span></label>
                            <input type="tel" value="{{ $user->telephone }}" class="form-control-lc disabled" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-lc">Email <span style="font-size:.72rem;color:var(--texte-2);">(optionnel)</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control-lc @error('email') border-danger @enderror"
                                placeholder="exemple@gmail.com">
                            @error('email') <div style="font-size:.78rem;color:var(--rouge);margin-top:.25rem;">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn-save">
                                <i class="bi bi-check2-circle"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Changer le mot de passe --}}
        <div class="pcard">
            <div class="pcard-header">
                <div class="pcard-icon" style="background:var(--vert-p);color:var(--vert);"><i class="bi bi-shield-lock-fill"></i></div>
                <h3 class="pcard-title">Changer mon mot de passe</h3>
            </div>
            <div class="pcard-body">
                <form method="POST" action="{{ route('eleve.profile.password') }}">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-lc">Mot de passe actuel</label>
                            <input type="password" name="current_password"
                                class="form-control-lc @error('current_password') border-danger @enderror"
                                placeholder="••••••••">
                            @error('current_password') <div style="font-size:.78rem;color:var(--rouge);margin-top:.25rem;">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-lc">Nouveau mot de passe</label>
                            <input type="password" name="password" id="newPwd"
                                class="form-control-lc @error('password') border-danger @enderror"
                                placeholder="Minimum 8 caractères"
                                oninput="checkPwStrength(this.value)">
                            <div class="pw-strength">
                                <div class="pw-strength-bar" id="pwBar"></div>
                            </div>
                            @error('password') <div style="font-size:.78rem;color:var(--rouge);margin-top:.25rem;">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-lc">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation"
                                class="form-control-lc" placeholder="••••••••">
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn-save btn-save-vert">
                                <i class="bi bi-shield-check"></i> Modifier le mot de passe
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    function checkPwStrength(val) {
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const bar = document.getElementById('pwBar');
        const colors = ['var(--rouge)', '#F97316', 'var(--or)', 'var(--vert)'];
        const widths = ['25%', '50%', '75%', '100%'];

        bar.style.width = score > 0 ? widths[score - 1] : '0%';
        bar.style.background = score > 0 ? colors[score - 1] : '';
    }

    // Animation barres de progression
    document.querySelectorAll('.prog-bar-fill').forEach(el => {
        const w = el.style.width;
        el.style.width = '0%';
        setTimeout(() => {
            el.style.width = w;
        }, 300);
    });
</script>
@endsection