@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord Directeur')

@section('head')
<style>
    .card-d {
        background: #fff;
        border-radius: var(--r);
        border: 1.5px solid var(--border);
        overflow: hidden;
        transition: .25s ease;
    }

    .card-d:hover {
        box-shadow: 0 8px 28px rgba(0, 0, 0, .07);
    }

    .card-d-body {
        padding: 1.4rem 1.5rem;
    }

    .card-d-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .card-d-title {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .95rem;
        color: var(--texte);
        margin: 0;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .card-d-link {
        font-size: .78rem;
        color: var(--rouge);
        text-decoration: none;
        font-weight: 700;
    }

    .card-d-link:hover {
        color: var(--rouge-c);
    }

    /* KPI */
    .kpi-card {
        background: #fff;
        border-radius: var(--r);
        border: 1.5px solid var(--border);
        padding: 1.25rem 1.4rem;
        position: relative;
        overflow: hidden;
        transition: .25s ease;
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
    }

    .kpi-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: .85rem;
    }

    .kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .kpi-badge {
        font-size: .7rem;
        font-weight: 700;
        padding: .25rem .6rem;
        border-radius: 50px;
        white-space: nowrap;
    }

    .kpi-val {
        font-family: 'Syne', sans-serif;
        font-size: 1.55rem;
        font-weight: 900;
        color: var(--texte);
        line-height: 1;
    }

    .kpi-lbl {
        font-size: .76rem;
        color: var(--texte-2);
        margin-top: .25rem;
    }

    .kpi-bar {
        height: 3px;
        border-radius: 2px;
        background: var(--border);
        margin-top: 1rem;
        overflow: hidden;
    }

    .kpi-bar-fill {
        height: 100%;
        border-radius: 2px;
        transition: width 1s ease .3s;
    }

    /* Graphique */
    .chart-area {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        height: 130px;
        padding: 0 .25rem;
    }

    .bar-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .bar-el {
        width: 100%;
        border-radius: 7px 7px 0 0;
        min-height: 4px;
        background: linear-gradient(180deg, var(--rouge), var(--rouge-c));
        transition: height .7s cubic-bezier(.4, 0, .2, 1);
        position: relative;
        cursor: pointer;
    }

    .bar-el:hover {
        filter: brightness(1.1);
    }

    .bar-el::after {
        content: attr(data-val);
        position: absolute;
        top: -22px;
        left: 50%;
        transform: translateX(-50%);
        font-size: .65rem;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        color: var(--texte);
        white-space: nowrap;
        opacity: 0;
        transition: .2s;
    }

    .bar-el:hover::after {
        opacity: 1;
    }

    .bar-lbl {
        font-size: .62rem;
        color: #9CA3AF;
        white-space: nowrap;
    }

    /* Timeline */
    .tl-item {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: .65rem .5rem;
        border-radius: 10px;
        transition: background .2s;
        margin: 0 -.5rem;
        border-bottom: 1px solid var(--bg);
    }

    .tl-item:last-child {
        border-bottom: none;
    }

    .tl-item:hover {
        background: var(--rouge-p);
    }

    .tl-av {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--rouge);
        color: #fff;
        font-family: 'Syne', sans-serif;
        font-weight: 900;
        font-size: .85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .tl-name {
        font-weight: 700;
        font-size: .85rem;
        color: var(--texte);
    }

    .tl-meta {
        font-size: .72rem;
        color: #9CA3AF;
        margin-top: .05rem;
    }

    /* Classement */
    .rank-item {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: .65rem .5rem;
        border-radius: 10px;
        transition: background .2s;
        margin: 0 -.5rem;
    }

    .rank-item:hover {
        background: var(--rouge-p);
    }

    .rank-score {
        font-family: 'Syne', sans-serif;
        font-weight: 900;
        font-size: .9rem;
        min-width: 44px;
        text-align: right;
    }

    .score-bar {
        height: 6px;
        border-radius: 3px;
        background: var(--border);
        overflow: hidden;
        flex: 1;
    }

    .score-bar-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 1s ease .4s;
    }

    /* Métriques */
    .metric-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .65rem 0;
        border-bottom: 1px solid var(--bg);
        font-size: .85rem;
    }

    .metric-row:last-child {
        border-bottom: none;
    }

    .metric-label {
        color: var(--texte-2);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .metric-value {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        color: var(--texte);
    }

    /* Actions */
    .action-a {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: .85rem 1rem;
        border-radius: 12px;
        margin-bottom: .5rem;
        text-decoration: none;
        transition: .2s ease;
        border: 1.5px solid transparent;
    }

    .action-a:hover {
        transform: translateX(4px);
    }

    .action-a-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .action-a-title {
        font-weight: 700;
        font-size: .84rem;
        color: var(--texte);
    }

    .action-a-sub {
        font-size: .74rem;
        color: var(--texte-2);
    }

    /* Donut */
    .donut-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        padding: .75rem 0;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: .55rem;
        font-size: .82rem;
        margin-bottom: .5rem;
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .legend-name {
        color: var(--texte-2);
    }

    .legend-val {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        color: var(--texte);
        margin-left: auto;
        min-width: 28px;
        text-align: right;
    }
</style>
@endsection

@section('content')

{{-- ── KPIs ─────────────────────────────────── --}}
<div class="row g-3 mb-4">
    @php
    $txPaiement = $totalEleves ? round(($elevesPayes/$totalEleves)*100) : 0;
    $kpis = [
    ['icon'=>'bi-people-fill', 'bg'=>'var(--rouge-p)', 'color'=>'var(--rouge)', 'c'=>'var(--rouge)', 'val'=>number_format($totalEleves), 'lbl'=>'Élèves inscrits', 'badge'=>null, 'bar'=>100, 'bcolor'=>'var(--rouge)'],
    ['icon'=>'bi-patch-check-fill', 'bg'=>'var(--vert-p)', 'color'=>'var(--vert)', 'c'=>'var(--vert)', 'val'=>number_format($elevesPayes), 'lbl'=>'Élèves payés', 'badge'=>$txPaiement.'% du total', 'bbg'=>'var(--vert-p)', 'bcolor2'=>'var(--vert-c)', 'bar'=>$txPaiement, 'bcolor'=>'var(--vert)'],
    ['icon'=>'bi-cash-stack', 'bg'=>'#FEFCE8', 'color'=>'#78350F', 'c'=>'#78350F', 'val'=>number_format($totalRevenu,0,',',' '), 'lbl'=>'Revenus totaux (XOF)','badge'=>null, 'bar'=>75, 'bcolor'=>'var(--or)'],
    ['icon'=>'bi-graph-up-arrow', 'bg'=>'#F3E8FF', 'color'=>'#7C3AED', 'c'=>'#7C3AED', 'val'=>number_format($revenuMois,0,',',' '), 'lbl'=>'Ce mois (XOF)', 'badge'=>now()->isoFormat('MMM YYYY'), 'bbg'=>'#F3E8FF','bcolor2'=>'#7C3AED','bar'=>60,'bcolor'=>'#7C3AED'],
    ['icon'=>'bi-folder-fill', 'bg'=>'var(--rouge-p)', 'color'=>'var(--rouge)', 'c'=>'var(--rouge)', 'val'=>$docsEnAttente, 'lbl'=>'Docs en attente', 'badge'=>$docsEnAttente>0?'À traiter':'OK','bbg'=>$docsEnAttente>0?'var(--rouge-p)':'var(--vert-p)','bcolor2'=>$docsEnAttente>0?'var(--rouge-c)':'var(--vert-c)','bar'=>min($docsEnAttente*10,100),'bcolor'=>'var(--rouge)'],
    ['icon'=>'bi-patch-question-fill','bg'=>'#FFF3CD', 'color'=>'#78350F', 'c'=>'#78350F', 'val'=>$quizAujourdhui, "lbl"=>"Quiz aujourd'hui", 'badge'=>null, 'bar'=>min($quizAujourdhui*5,100),'bcolor'=>'var(--or)'],
    ];
    @endphp
    @foreach($kpis as $k)
    <div class="col-6 col-md-4 col-xl-2">
        <div class="kpi-card" style="color:{{ $k['c'] }}">
            <div class="kpi-top">
                <div class="kpi-icon" style="background:{{ $k['bg'] }};color:{{ $k['color'] }};"><i class="bi {{ $k['icon'] }}"></i></div>
                @if($k['badge'] ?? null)<span class="kpi-badge" style="background:{{ $k['bbg']??'var(--bg)' }};color:{{ $k['bcolor2']??'#6B7280' }};">{{ $k['badge'] }}</span>@endif
            </div>
            <div class="kpi-val">{{ $k['val'] }}</div>
            <div class="kpi-lbl">{{ $k['lbl'] }}</div>
            <div class="kpi-bar">
                <div class="kpi-bar-fill" style="width:0%;background:{{ $k['bcolor'] }};" data-width="{{ $k['bar'] }}"></div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ── Graphique + Donut + Actions ─────────── --}}
<div class="row g-3 mb-4">

    <div class="col-lg-5">
        <div class="card-d h-100">
            <div class="card-d-header">
                <h3 class="card-d-title"><i class="bi bi-bar-chart-fill" style="color:var(--rouge);"></i>Revenus — 6 derniers mois</h3>
                <a href="{{ route('admin.reporting.index') }}" class="card-d-link">Détails →</a>
            </div>
            <div class="card-d-body">
                @if($revenusParMois->count())
                @php $maxRev=$revenusParMois->max('total')?:1; $mL=['01'=>'Jan','02'=>'Fév','03'=>'Mar','04'=>'Avr','05'=>'Mai','06'=>'Jun','07'=>'Jul','08'=>'Aoû','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Déc']; @endphp
                <div class="chart-area">
                    @foreach($revenusParMois as $r)
                    @php $h=max(6,round(($r->total/$maxRev)*118)); $p=explode('-',$r->mois); $lbl=$mL[$p[1]]??$p[1]; $val=number_format($r->total/1000,0).'k'; @endphp
                    <div class="bar-col">
                        <div class="bar-el" style="height:0px;" data-height="{{ $h }}" data-val="{{ $val }} XOF"></div>
                        <div class="bar-lbl">{{ $lbl }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-between mt-3 pt-3" style="border-top:1px solid var(--border);">
                    <div>
                        <div style="font-size:.72rem;color:#9CA3AF;">Total période</div>
                        <div style="font-family:'Syne',sans-serif;font-weight:900;font-size:.93rem;">{{ number_format($revenusParMois->sum('total'),0,',',' ') }} XOF</div>
                    </div>
                    <div class="text-end">
                        <div style="font-size:.72rem;color:#9CA3AF;">Transactions</div>
                        <div style="font-family:'Syne',sans-serif;font-weight:900;font-size:.93rem;">{{ $revenusParMois->sum('nb') }}</div>
                    </div>
                </div>
                @else
                <div class="text-center py-5" style="color:#CBD5E1;"><i class="bi bi-bar-chart" style="font-size:2.5rem;display:block;margin-bottom:.5rem;"></i><span style="font-size:.85rem;">Aucune transaction récente.</span></div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-d h-100">
            <div class="card-d-header">
                <h3 class="card-d-title"><i class="bi bi-pie-chart-fill" style="color:var(--vert);"></i>Répartition élèves</h3>
            </div>
            <div class="card-d-body">
                @php
                $nonPayes=$totalEleves-$elevesPayes;
                $pctPaye=$totalEleves?round($elevesPayes/$totalEleves*100):0;
                $r2=38; $circ=round(2*3.14159*$r2,2);
                $dashPaye=round($circ*$pctPaye/100,2); $dashNon=$circ-$dashPaye;
                @endphp
                <div class="donut-wrap">
                    <svg width="110" height="110" viewBox="0 0 110 110">
                        <circle cx="55" cy="55" r="{{ $r2 }}" fill="none" stroke="var(--border)" stroke-width="14" />
                        <circle cx="55" cy="55" r="{{ $r2 }}" fill="none" stroke="var(--vert)" stroke-width="14" stroke-dasharray="{{ $dashPaye }} {{ $dashNon }}" stroke-dashoffset="{{ round($circ*.25,2) }}" stroke-linecap="round" />
                        <circle cx="55" cy="55" r="{{ $r2 }}" fill="none" stroke="var(--rouge)" stroke-width="14" stroke-dasharray="{{ $dashNon }} {{ $dashPaye }}" stroke-dashoffset="{{ round($circ*.25-$dashPaye,2) }}" stroke-linecap="round" opacity=".25" />
                        <text x="55" y="50" text-anchor="middle" font-family="Syne,sans-serif" font-weight="900" font-size="16" fill="var(--texte)">{{ $pctPaye }}%</text>
                        <text x="55" y="65" text-anchor="middle" font-family="DM Sans,sans-serif" font-size="9" fill="var(--texte-2)">Payés</text>
                    </svg>
                    <div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--vert);"></div><span class="legend-name">Payés</span><span class="legend-val">{{ $elevesPayes }}</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:rgba(200,16,46,.3);"></div><span class="legend-name">En attente</span><span class="legend-val">{{ $nonPayes }}</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--border);"></div><span class="legend-name">Total</span><span class="legend-val">{{ $totalEleves }}</span>
                        </div>
                    </div>
                </div>
                <div style="border-top:1px solid var(--border);padding-top:1rem;margin-top:.5rem;">
                    <div class="metric-row"><span class="metric-label"><i class="bi bi-folder-fill" style="color:var(--rouge);"></i>Docs à valider</span><span class="metric-value" style="{{ $docsEnAttente>0?'color:var(--rouge);':'' }}">{{ $docsEnAttente }}</span></div>
                    <div class="metric-row"><span class="metric-label"><i class="bi bi-patch-question-fill" style="color:var(--or);"></i>Quiz du jour</span><span class="metric-value">{{ $quizAujourdhui }}</span></div>
                    <div class="metric-row"><span class="metric-label"><i class="bi bi-cash-stack" style="color:var(--vert);"></i>Mois en cours</span><span class="metric-value">{{ number_format($revenuMois,0,',',' ') }} XOF</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card-d h-100">
            <div class="card-d-header">
                <h3 class="card-d-title"><i class="bi bi-lightning-fill" style="color:var(--rouge);"></i>Actions rapides</h3>
            </div>
            <div class="card-d-body">
                @if($docsEnAttente > 0)
                <a href="{{ route('admin.documents.index') }}?status=en_attente" class="action-a" style="background:var(--rouge-p);border-color:rgba(200,16,46,.2);">
                    <div class="action-a-icon" style="background:#FECACA;"><i class="bi bi-folder-fill" style="color:var(--rouge);"></i></div>
                    <div>
                        <div class="action-a-title">{{ $docsEnAttente }} doc(s) en attente</div>
                        <div class="action-a-sub">Cliquer pour valider</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="font-size:.75rem;color:#9CA3AF;"></i>
                </a>
                @endif
                <a href="{{ route('admin.eleves.index') }}?statut=non_paye" class="action-a" style="background:var(--vert-p);border-color:rgba(0,154,68,.2);">
                    <div class="action-a-icon" style="background:#BBF7D0;"><i class="bi bi-person-exclamation" style="color:var(--vert);"></i></div>
                    <div>
                        <div class="action-a-title">{{ $totalEleves-$elevesPayes }} non payés</div>
                        <div class="action-a-sub">Voir la liste</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="font-size:.75rem;color:#9CA3AF;"></i>
                </a>
                <a href="{{ route('admin.reporting.export') }}" class="action-a" style="background:var(--vert-p);border-color:rgba(0,154,68,.2);">
                    <div class="action-a-icon" style="background:#BBF7D0;"><i class="bi bi-file-earmark-excel-fill" style="color:var(--vert);"></i></div>
                    <div>
                        <div class="action-a-title">Exporter Excel</div>
                        <div class="action-a-sub">Transactions Wave</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="font-size:.75rem;color:#9CA3AF;"></i>
                </a>
                <a href="{{ route('admin.eleves.export') }}" class="action-a" style="background:var(--bg);border-color:var(--border);margin-bottom:0;">
                    <div class="action-a-icon" style="background:var(--rouge-p);"><i class="bi bi-people-fill" style="color:var(--rouge);"></i></div>
                    <div>
                        <div class="action-a-title">Export élèves</div>
                        <div class="action-a-sub">Fiche complète CRM</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="font-size:.75rem;color:#9CA3AF;"></i>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── Inscriptions + Classement ────────────── --}}
<div class="row g-3">
    <div class="col-lg-5">
        <div class="card-d">
            <div class="card-d-header">
                <h3 class="card-d-title"><i class="bi bi-person-plus-fill" style="color:var(--rouge);"></i>Dernières inscriptions</h3>
                <a href="{{ route('admin.eleves.index') }}" class="card-d-link">Voir tout →</a>
            </div>
            <div class="card-d-body">
                @forelse($inscriptionsRecentes as $eleve)
                <div class="tl-item">
                    <div class="tl-av">{{ strtoupper(substr($eleve->prenom,0,1)) }}</div>
                    <div class="flex-grow-1 min-width-0">
                        <div class="tl-name">{{ strtoupper($eleve->nom) }} {{ $eleve->prenom }}</div>
                        <div class="tl-meta"><i class="bi bi-telephone" style="font-size:.65rem;"></i> {{ $eleve->telephone }} · {{ $eleve->created_at->diffForHumans() }}</div>
                    </div>
                    @if($eleve->payments->count())
                    <span style="background:var(--vert-p);color:var(--vert-c);font-size:.7rem;font-weight:700;padding:.22rem .65rem;border-radius:50px;flex-shrink:0;"><i class="bi bi-check2"></i> Payé</span>
                    @else
                    <span style="background:#FEFCE8;color:#78350F;font-size:.7rem;font-weight:700;padding:.22rem .65rem;border-radius:50px;flex-shrink:0;">En attente</span>
                    @endif
                </div>
                @empty
                <div class="text-center py-4" style="color:#CBD5E1;font-size:.85rem;"><i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Aucun élève inscrit.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card-d">
            <div class="card-d-header">
                <h3 class="card-d-title"><i class="bi bi-trophy-fill" style="color:var(--or);"></i>Classement QCM — Meilleurs scores</h3>
                <a href="{{ route('admin.reporting.index') }}" class="card-d-link">Suivi →</a>
            </div>
            <div class="card-d-body">
                @if($topEleves->count())
                @php $medals=['🥇','🥈','🥉']; @endphp
                @foreach($topEleves as $i => $e)
                @php $moy=round($e->moyenne??0); $barC=$moy>=80?'var(--vert)':($moy>=60?'var(--or)':'var(--rouge)'); @endphp
                <div class="rank-item">
                    <div class="d-flex align-items-center gap-2" style="min-width:135px;flex:1.2;">
                        <span style="font-family:'Syne',sans-serif;font-weight:900;font-size:.9rem;min-width:22px;text-align:center;">{{ $medals[$i] ?? $i+1 }}</span>
                        <div style="width:30px;height:30px;border-radius:50%;background:var(--rouge);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.75rem;font-family:'Syne',sans-serif;flex-shrink:0;">
                            {{ strtoupper(substr($e->user->prenom??'?',0,1)) }}
                        </div>
                        <span style="font-weight:700;font-size:.83rem;color:var(--texte);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:80px;">{{ $e->user->nom ?? '—' }}</span>
                    </div>
                    <div class="score-bar">
                        <div class="score-bar-fill" style="width:0%;background:{{ $barC }};" data-width="{{ $moy }}"></div>
                    </div>
                    <div style="min-width:32px;text-align:center;font-size:.8rem;color:#9CA3AF;">{{ $e->nb_quiz }}</div>
                    <div class="rank-score" style="color:{{ $barC }};">{{ $moy }}%</div>
                </div>
                @endforeach
                @else
                <div class="text-center py-5" style="color:#CBD5E1;"><i class="bi bi-patch-question" style="font-size:2.5rem;display:block;margin-bottom:.5rem;"></i><span style="font-size:.85rem;">Aucun quiz effectué.</span></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.kpi-bar-fill').forEach(el => {
        const w = el.dataset.width;
        setTimeout(() => {
            el.style.width = w + '%'
        }, 300);
    });
    document.querySelectorAll('.bar-el').forEach(bar => {
        const h = bar.dataset.height;
        bar.style.height = '0px';
        setTimeout(() => {
            bar.style.height = h + 'px'
        }, 250);
    });
    document.querySelectorAll('.score-bar-fill').forEach(el => {
        const w = el.dataset.width;
        setTimeout(() => {
            el.style.width = w + '%'
        }, 500);
    });
</script>
@endsection