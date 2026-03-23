@extends('layouts.app')
@section('title', 'Gestion des Élèves')
@section('page-title', 'Élèves & CRM')

@section('head')
<style>
.card-a { background:#fff; border-radius:var(--r); padding:1.4rem; border:1.5px solid var(--border); }
.tbl td,.tbl th { padding:.6rem .85rem; font-size:.83rem; vertical-align:middle; border-color:var(--bg); }
.tbl thead tr { background:var(--rouge); color:#fff; }
.tbl thead th { font-family:'Syne',sans-serif; font-weight:700; font-size:.75rem; text-transform:uppercase; letter-spacing:.05em; border:none; }
.tbl tbody tr { transition:.15s ease; }
.tbl tbody tr:hover { background:var(--rouge-p); }
.av { width:32px;height:32px;border-radius:50%;background:var(--rouge);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.78rem;flex-shrink:0; }
.b-paye   { background:var(--vert-p);  color:var(--vert-c); font-size:.72rem; padding:.28rem .65rem; border-radius:50px; font-weight:700; }
.b-nopaye { background:#FEFCE8;        color:#78350F;        font-size:.72rem; padding:.28rem .65rem; border-radius:50px; font-weight:700; }
.search-wrap { position:relative; }
.search-wrap .bi { position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:#9CA3AF; }
.search-in {
    border:1.5px solid var(--border); border-radius:10px;
    padding:.55rem 1rem .55rem 2.6rem; font-size:.87rem; width:100%;
}
.search-in:focus { border-color:var(--rouge); outline:none; box-shadow:0 0 0 3px rgba(200,16,46,.12); }
.btn-export {
    background:linear-gradient(135deg,var(--vert),var(--vert-c));
    color:#fff; border:none; border-radius:10px; padding:.6rem 1.2rem;
    font-weight:700; font-size:.84rem; display:inline-flex; align-items:center; gap:.5rem;
    text-decoration:none; transition:.2s ease;
}
.btn-export:hover { opacity:.9; color:#fff; transform:translateY(-1px); }
.filter-chip {
    display:inline-flex; align-items:center; gap:.35rem;
    background:var(--rouge-p); color:var(--rouge-c);
    font-size:.76rem; font-weight:700; padding:.28rem .75rem; border-radius:50px;
}
.btn-filter { background:var(--rouge); color:#fff; border:none; border-radius:8px; padding:.42rem .9rem; font-size:.84rem; font-weight:600; display:flex; align-items:center; gap:.35rem; }
.btn-reset  { background:var(--bg); color:var(--texte-2); border:1.5px solid var(--border); border-radius:8px; padding:.42rem .75rem; font-size:.84rem; text-decoration:none; display:flex; align-items:center; }
#noResults  { display:none; text-align:center; padding:2.5rem; color:#9CA3AF; font-size:.88rem; }
</style>
@endsection

@section('content')

{{-- Toolbar --}}
<div class="card-a mb-3">
    <div class="row g-2 align-items-end">

        {{-- Recherche rapide JS --}}
        <div class="col-md-4">
            <label style="font-size:.78rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.3rem;">
                <i class="bi bi-search me-1" style="color:var(--rouge);"></i>Recherche rapide
            </label>
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="search-in"
                       placeholder="Nom, prénom, téléphone…"
                       oninput="filterTable(this.value)" autocomplete="off">
            </div>
        </div>

        {{-- Filtres serveur --}}
        <div class="col-md-6">
            <form method="GET" class="d-flex gap-2 flex-wrap align-items-end">
                <div>
                    <label style="font-size:.76rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.3rem;">Du</label>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}"
                           class="form-control form-control-sm" style="border-radius:8px;border-color:var(--border);">
                </div>
                <div>
                    <label style="font-size:.76rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.3rem;">Au</label>
                    <input type="date" name="date_fin" value="{{ request('date_fin') }}"
                           class="form-control form-control-sm" style="border-radius:8px;border-color:var(--border);">
                </div>
                <div>
                    <label style="font-size:.76rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.3rem;">Statut</label>
                    <select name="statut" class="form-select form-select-sm" style="border-radius:8px;border-color:var(--border);">
                        <option value="">Tous</option>
                        <option value="paye"    {{ request('statut')==='paye'?'selected':'' }}>Payé</option>
                        <option value="non_paye"{{ request('statut')==='non_paye'?'selected':'' }}>Non payé</option>
                    </select>
                </div>
                <div class="d-flex gap-1 align-items-end">
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-funnel-fill"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.eleves.index') }}" class="btn-reset">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>

        {{-- Export --}}
        <div class="col-md-2 text-md-end">
            <a href="{{ route('admin.eleves.export') }}" class="btn-export">
                <i class="bi bi-file-earmark-excel-fill"></i>Excel
            </a>
        </div>
    </div>

    @if(request()->hasAny(['date_debut','date_fin','statut']))
    <div class="mt-2 d-flex gap-2 flex-wrap">
        @if(request('date_debut'))<span class="filter-chip"><i class="bi bi-calendar3"></i>Depuis {{ request('date_debut') }}</span>@endif
        @if(request('date_fin'))<span class="filter-chip"><i class="bi bi-calendar3"></i>Jusqu'au {{ request('date_fin') }}</span>@endif
        @if(request('statut'))<span class="filter-chip"><i class="bi bi-funnel"></i>{{ request('statut')==='paye' ? 'Payés' : 'Non payés' }}</span>@endif
    </div>
    @endif
</div>

{{-- Tableau --}}
<div class="card-a">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <span style="font-family:'Syne',sans-serif;font-weight:800;font-size:.95rem;color:var(--texte);">
            <span id="countDisplay">{{ $eleves->total() }}</span> élève(s)
        </span>
        <span style="font-size:.78rem;color:var(--texte-2);">Page {{ $eleves->currentPage() }}/{{ $eleves->lastPage() }}</span>
    </div>

    <div class="table-responsive">
        <table class="table tbl mb-0" id="elevesTable">
            <thead>
                <tr>
                    <th>Élève</th>
                    <th>Téléphone</th>
                    <th>Inscription</th>
                    <th>Paiement</th>
                    <th>Docs</th>
                    <th>Quiz</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($eleves as $eleve)
                <tr class="eleve-row" data-search="{{ strtolower($eleve->nom.' '.$eleve->prenom.' '.$eleve->telephone) }}">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="av">{{ strtoupper(substr($eleve->prenom,0,1)) }}</div>
                            <div>
                                <div style="font-weight:700;color:var(--texte);">{{ strtoupper($eleve->nom) }} {{ $eleve->prenom }}</div>
                                <div style="font-size:.73rem;color:#9CA3AF;">{{ $eleve->email ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:.84rem;">{{ $eleve->telephone }}</td>
                    <td style="font-size:.82rem;color:var(--texte-2);">{{ $eleve->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($eleve->payments->count())
                        <span class="b-paye"><i class="bi bi-check2-circle me-1"></i>Payé</span>
                        @else
                        <span class="b-nopaye"><i class="bi bi-clock me-1"></i>En attente</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-family:'Syne',sans-serif;font-weight:800;color:var(--texte);">{{ $eleve->documents_count }}</span>
                    </td>
                    <td>
                        <span style="font-family:'Syne',sans-serif;font-weight:800;color:var(--texte);">{{ $eleve->quiz_scores_count }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.eleves.show', $eleve) }}"
                           class="btn btn-sm"
                           style="background:var(--rouge-p);color:var(--rouge);border-radius:8px;font-size:.78rem;border:none;">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#9CA3AF;">
                        <i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                        Aucun élève trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div id="noResults">
            <i class="bi bi-search" style="font-size:2rem;color:#CBD5E1;display:block;margin-bottom:.5rem;"></i>
            Aucun résultat pour cette recherche.
        </div>
    </div>
    <div class="mt-3">{{ $eleves->links() }}</div>
</div>

@endsection
@section('scripts')
<script>
function filterTable(q) {
    q = q.toLowerCase().trim();
    const rows = document.querySelectorAll('.eleve-row');
    let n = 0;
    rows.forEach(r => {
        const show = !q || r.dataset.search.includes(q);
        r.style.display = show ? '' : 'none';
        if (show) n++;
    });
    document.getElementById('countDisplay').textContent = n;
    document.getElementById('noResults').style.display = (!n && q) ? 'block' : 'none';
}
document.getElementById('searchInput')?.focus();
</script>
@endsectionrn