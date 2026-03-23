@extends('layouts.app')
@section('title', 'Reporting Financier')
@section('page-title', 'Reporting & Analytics')

@section('head')
<style>
    .card-a {
        background: #fff;
        border-radius: var(--r);
        padding: 1.4rem;
        border: 1.5px solid var(--border);
    }

    /* KPIs revenus */
    .kpi-rev {
        border-radius: var(--r);
        padding: 1.3rem;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .kpi-rev::after {
        content: '';
        position: absolute;
        right: -20px;
        top: -20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
    }

    .kpi-rev .val {
        font-family: 'Syne', sans-serif;
        font-size: 1.8rem;
        font-weight: 900;
        line-height: 1;
    }

    .kpi-rev .lbl {
        font-size: .78rem;
        opacity: .8;
        margin-top: .25rem;
    }

    /* Table transactions */
    .tbl td,
    .tbl th {
        padding: .55rem .75rem;
        font-size: .82rem;
        vertical-align: middle;
        border-color: var(--bg);
    }

    .tbl thead tr {
        background: var(--rouge);
        color: #fff;
    }

    .tbl thead th {
        font-family: 'Syne', sans-serif;
        font-size: .74rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        border: none;
    }

    .tbl tbody tr:hover {
        background: var(--rouge-p);
    }

    .av {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--rouge);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: .75rem;
        flex-shrink: 0;
    }

    .b-ok {
        background: var(--vert-p);
        color: var(--vert-c);
        font-size: .7rem;
        padding: .25rem .6rem;
        border-radius: 50px;
        font-weight: 700;
    }

    .b-att {
        background: #FEFCE8;
        color: #78350F;
        font-size: .7rem;
        padding: .25rem .6rem;
        border-radius: 50px;
        font-weight: 700;
    }

    .b-ko {
        background: var(--rouge-p);
        color: var(--rouge-c);
        font-size: .7rem;
        padding: .25rem .6rem;
        border-radius: 50px;
        font-weight: 700;
    }

    .btn-excel {
        background: linear-gradient(135deg, var(--vert), var(--vert-c));
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: .6rem 1.2rem;
        font-weight: 700;
        font-size: .84rem;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        text-decoration: none;
        transition: .2s;
    }

    .btn-excel:hover {
        opacity: .9;
        color: #fff;
    }

    .btn-filter {
        background: var(--rouge);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: .42rem .9rem;
        font-size: .84rem;
    }

    /* Section pédagogie */
    .section-title {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .93rem;
        color: var(--texte);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .diff-row {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .65rem .35rem;
        border-bottom: 1px solid var(--bg);
    }

    .diff-row:last-child {
        border-bottom: none;
    }

    .prog {
        height: 6px;
        border-radius: 3px;
        background: var(--border);
        overflow: hidden;
        flex: 1;
    }

    .prog-bar {
        height: 100%;
        border-radius: 3px;
    }

    .score-chip {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .82rem;
        min-width: 42px;
        text-align: right;
    }
</style>
@endsection

@section('content')

{{-- KPIs financiers --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-rev" style="background:linear-gradient(135deg,var(--rouge),var(--rouge-c));">
            <div class="lbl">Revenus totaux</div>
            <div class="val">{{ number_format($totaux['total_global'],0,',',' ') }}</div>
            <div style="font-size:.72rem;opacity:.6;margin-top:.25rem;">XOF — Tous temps</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-rev" style="background:linear-gradient(135deg,var(--vert),var(--vert-c));">
            <div class="lbl">Ce mois</div>
            <div class="val">{{ number_format($totaux['total_mois'],0,',',' ') }}</div>
            <div style="font-size:.72rem;opacity:.7;margin-top:.25rem;">XOF — {{ now()->isoFormat('MMMM YYYY') }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-rev" style="background:linear-gradient(135deg,var(--vert),var(--texte));">
            <div class="lbl">Transactions confirmées</div>
            <div class="val">{{ $totaux['nb_transactions'] }}</div>
            <div style="font-size:.72rem;opacity:.7;margin-top:.25rem;">Paiements Wave</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-rev" style="background:linear-gradient(135deg,#78350F,#B8860B);">
            <div class="lbl">En attente</div>
            <div class="val">{{ $totaux['nb_pending'] }}</div>
            <div style="font-size:.72rem;opacity:.7;margin-top:.25rem;">Paiements pendants</div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Tableau transactions --}}
    <div class="col-lg-8">
        <div class="card-a">
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <div class="section-title mb-0">
                    <i class="bi bi-credit-card-fill" style="color:var(--rouge);"></i>
                    Transactions Wave
                </div>
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <form method="GET" class="d-flex gap-1 align-items-center flex-wrap">
                        <input type="date" name="date_debut" value="{{ request('date_debut') }}"
                            class="form-control form-control-sm" style="border-radius:8px;width:128px;">
                        <span style="font-size:.8rem;color:#9CA3AF;">→</span>
                        <input type="date" name="date_fin" value="{{ request('date_fin') }}"
                            class="form-control form-control-sm" style="border-radius:8px;width:128px;">
                        <select name="statut" class="form-select form-select-sm" style="border-radius:8px;width:auto;">
                            <option value="">Tous</option>
                            <option value="completed" {{ request('statut')==='completed'?'selected':'' }}>Confirmés</option>
                            <option value="pending" {{ request('statut')==='pending'?'selected':'' }}>En attente</option>
                            <option value="failed" {{ request('statut')==='failed'?'selected':'' }}>Échoués</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-filter">
                            <i class="bi bi-funnel-fill"></i>
                        </button>
                    </form>
                    <a href="{{ route('admin.reporting.export', request()->query()) }}" class="btn-excel">
                        <i class="bi bi-file-earmark-excel-fill"></i>Excel
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table tbl mb-0">
                    <thead>
                        <tr>
                            <th>N° Reçu</th>
                            <th>Élève</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $p)
                        <tr>
                            <td style="font-family:monospace;font-size:.79rem;color:var(--texte-2);">{{ $p->receipt_number ?? '—' }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="av">{{ strtoupper(substr($p->user->prenom??'?',0,1)) }}</div>
                                    <div>
                                        <div style="font-weight:700;color:var(--texte);">{{ $p->user->nom_complet ?? '—' }}</div>
                                        <div style="font-size:.71rem;color:#9CA3AF;">{{ $p->user->telephone ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-family:'Syne',sans-serif;font-weight:900;color:var(--texte);">{{ number_format($p->amount,0,',',' ') }}</span>
                                <span style="font-size:.71rem;color:#9CA3AF;"> XOF</span>
                            </td>
                            <td style="font-size:.79rem;color:var(--texte-2);">{{ $p->paid_at?->format('d/m/Y H:i') ?? $p->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($p->status === 'completed') <span class="b-ok">✅ Confirmé</span>
                                @elseif($p->status === 'pending') <span class="b-att">⏳ En attente</span>
                                @else <span class="b-ko">❌ Échoué</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4" style="color:#9CA3AF;">Aucune transaction.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $payments->links() }}</div>
        </div>
    </div>

    {{-- Suivi pédagogique --}}
    <div class="col-lg-4">

        {{-- Élèves en difficulté --}}
        <div class="card-a mb-3">
            <div class="section-title">
                <i class="bi bi-exclamation-triangle-fill" style="color:var(--rouge);"></i>
                Élèves en difficulté
                <span style="background:var(--rouge-p);color:var(--rouge-c);font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:50px;margin-left:.25rem;">
                    &lt; 60%
                </span>
            </div>
            @forelse($elevesEnDifficulte->take(8) as $eleve)
            <div class="diff-row">
                <div style="width:28px;height:28px;border-radius:50%;background:var(--rouge);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.72rem;flex-shrink:0;">
                    {{ strtoupper(substr($eleve->prenom??'?',0,1)) }}
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:700;font-size:.81rem;color:var(--texte);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $eleve->nom }} {{ $eleve->prenom }}
                    </div>
                    @php $moy = min($eleve->moy_code ?? $eleve->moy_conduite ?? 0, 100); @endphp
                    <div class="prog mt-1">
                        <div class="prog-bar" style="width:{{ $moy }}%;background:{{ $moy>=60?'var(--vert)':($moy>=40?'var(--or)':'var(--rouge)') }};"></div>
                    </div>
                </div>
                <div class="score-chip" style="color:{{ $moy>=60?'var(--vert)':'var(--rouge)' }};">
                    {{ $moy > 0 ? number_format($moy,0).'%' : 'N/A' }}
                </div>
            </div>
            @empty
            <div class="text-center py-3" style="font-size:.85rem;color:#9CA3AF;">
                <i class="bi bi-check-circle-fill" style="color:var(--vert);"></i>
                Tous au-dessus du seuil.
            </div>
            @endforelse
        </div>

        {{-- Classement code --}}
        <div class="card-a">
            <div class="section-title">
                <i class="bi bi-bar-chart-steps" style="color:var(--rouge);"></i>
                Code — Moins bons scores
            </div>
            @forelse($classementCode->take(6) as $i => $e)
            <div class="d-flex align-items-center gap-2 py-2 border-bottom">
                <span style="font-family:'Syne',sans-serif;font-weight:900;font-size:.83rem;color:#9CA3AF;min-width:18px;">{{ $i+1 }}</span>
                <div style="width:26px;height:26px;border-radius:50%;background:var(--rouge);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.7rem;flex-shrink:0;">
                    {{ strtoupper(substr($e->user->prenom??'?',0,1)) }}
                </div>
                <div class="flex-grow-1 min-width-0">
                    <div style="font-size:.81rem;font-weight:700;color:var(--texte);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $e->user->nom_complet ?? '—' }}</div>
                    <div style="font-size:.71rem;color:#9CA3AF;">{{ $e->nb }} quiz</div>
                </div>
                <span style="font-family:'Syne',sans-serif;font-weight:900;font-size:.85rem;color:{{ $e->moyenne>=80?'var(--vert)':($e->moyenne>=60?'var(--or)':'var(--rouge)') }};">
                    {{ number_format($e->moyenne,0) }}%
                </span>
            </div>
            @empty
            <p class="text-center py-3" style="font-size:.85rem;color:#9CA3AF;">Aucune donnée.</p>
            @endforelse
        </div>

    </div>
</div>
@endsection