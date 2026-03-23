@extends('layouts.app')
@section('title', 'Documents Élèves')
@section('page-title', 'Gestion des Documents')

@section('head')
<style>
.card-a  { background:#fff; border-radius:var(--r); padding:1.4rem; border:1.5px solid var(--border); }
.kpi-doc { background:var(--bg); border-radius:12px; padding:.9rem 1rem; text-align:center; border:1.5px solid var(--border); transition:.2s ease; }
.kpi-doc:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.07); }
.kpi-doc .val { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:900; display:block; }
.kpi-doc .lbl { font-size:.72rem; color:var(--texte-2); display:block; margin-top:.1rem; }

.tbl td,.tbl th { padding:.6rem .85rem; font-size:.82rem; vertical-align:middle; border-color:var(--bg); }
.tbl thead tr { background:var(--rouge); color:#fff; }
.tbl thead th { font-family:'Syne',sans-serif; font-size:.74rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; border:none; }
.tbl tbody tr:hover { background:var(--rouge-p); }

.av { width:30px;height:30px;border-radius:50%;background:var(--rouge);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.75rem;flex-shrink:0; }
.dtype { width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.95rem;flex-shrink:0; }

.bs { font-size:.7rem; padding:.28rem .65rem; border-radius:50px; font-weight:700; cursor:pointer; border:none; transition:.15s ease; }
.bs:hover { opacity:.85; }
.bs-att { background:#FEFCE8; color:#78350F; }
.bs-val { background:var(--vert-p); color:var(--vert-c); }
.bs-rej { background:var(--rouge-p); color:var(--rouge-c); }

.btn-filter { background:var(--rouge); color:#fff; border:none; border-radius:8px; padding:.42rem .9rem; font-size:.84rem; display:flex; align-items:center; gap:.35rem; }
.btn-reset  { background:var(--bg); color:var(--texte-2); border:1.5px solid var(--border); border-radius:8px; padding:.42rem .75rem; font-size:.84rem; text-decoration:none; display:flex; align-items:center; }
.btn-print  { background:#6B7280; color:#fff; border:none; border-radius:8px; padding:.42rem .75rem; font-size:.84rem; display:flex; align-items:center; gap:.3rem; text-decoration:none; }
.btn-dl     { background:var(--rouge-p); color:var(--rouge); border:none; border-radius:8px; padding:.3rem .55rem; font-size:.78rem; }

/* Modal */
.modal-validate .modal-content  { border-radius:18px; border:none; box-shadow:0 20px 60px rgba(0,0,0,.2); }
.modal-validate .modal-header    { background:var(--rouge); color:#fff; border-radius:18px 18px 0 0; padding:1.2rem 1.5rem; border:none; }
.modal-validate .modal-title     { font-family:'Syne',sans-serif; font-weight:800; }
.btn-val { background:var(--vert); color:#fff; border:none; border-radius:9px; padding:.55rem 1.25rem; font-weight:700; font-size:.85rem; flex:1; transition:.2s; }
.btn-val:hover { background:var(--vert-c); }
.btn-rej { background:var(--rouge); color:#fff; border:none; border-radius:9px; padding:.55rem 1.25rem; font-weight:700; font-size:.85rem; flex:1; transition:.2s; }
.btn-rej:hover { background:var(--rouge-c); }
</style>
@endsection

@section('content')

{{-- KPIs --}}
<div class="row g-3 mb-3">
    @php
    $kpiDocs = [
        ['val'=>$stats['total'],     'lbl'=>'Total',      'color'=>'var(--texte)'],
        ['val'=>$stats['en_attente'],'lbl'=>'En attente', 'color'=>'#78350F'],
        ['val'=>$stats['valides'],   'lbl'=>'Validés',    'color'=>'var(--vert)'],
        ['val'=>$stats['rejetes'],   'lbl'=>'Rejetés',    'color'=>'var(--rouge)'],
    ];
    @endphp
    @foreach($kpiDocs as $k)
    <div class="col-6 col-md-3">
        <div class="kpi-doc">
            <span class="val" style="color:{{ $k['color'] }}">{{ $k['val'] }}</span>
            <span class="lbl">{{ $k['lbl'] }}</span>
        </div>
    </div>
    @endforeach
</div>

{{-- Filtres --}}
<div class="card-a mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label style="font-size:.76rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.3rem;">Statut</label>
            <select name="status" class="form-select form-select-sm" style="border-radius:8px;">
                <option value="">Tous</option>
                <option value="en_attente" {{ request('status')==='en_attente'?'selected':'' }}>En attente</option>
                <option value="valide"     {{ request('status')==='valide'?'selected':'' }}>Validés</option>
                <option value="rejete"     {{ request('status')==='rejete'?'selected':'' }}>Rejetés</option>
            </select>
        </div>
        <div class="col-md-3">
            <label style="font-size:.76rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.3rem;">Type</label>
            <select name="type" class="form-select form-select-sm" style="border-radius:8px;">
                <option value="">Tous</option>
                @foreach(App\Models\Document::LABELS_TYPE as $val => $lbl)
                <option value="{{ $val }}" {{ request('type')===$val?'selected':'' }}>{{ $lbl }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label style="font-size:.76rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.3rem;">Rechercher un élève</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control form-control-sm" placeholder="Nom, prénom, téléphone…" style="border-radius:8px;">
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn-filter flex-grow-1">
                <i class="bi bi-funnel-fill"></i>
            </button>
            <a href="{{ route('admin.documents.index') }}" class="btn-reset"><i class="bi bi-x-lg"></i></a>
            <a href="{{ route('admin.documents.print') }}" class="btn-print" target="_blank">
                <i class="bi bi-printer-fill"></i>
            </a>
        </div>
    </form>
</div>

{{-- Tableau --}}
<div class="card-a">
    <div class="table-responsive">
        <table class="table tbl mb-0">
            <thead>
                <tr>
                    <th>Élève</th>
                    <th>Type</th>
                    <th>Fichier</th>
                    <th>Déposé le</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="av">{{ strtoupper(substr($doc->user->prenom??'?',0,1)) }}</div>
                            <div>
                                <div style="font-weight:700;color:var(--texte);">{{ $doc->user->nom_complet ?? '—' }}</div>
                                <div style="font-size:.72rem;color:#9CA3AF;">{{ $doc->user->telephone ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                        $tc = ['cni'=>['bi-person-badge-fill','var(--rouge-p)','var(--rouge)'],'photo'=>['bi-image-fill','#FEFCE8','#78350F'],'certificat'=>['bi-file-medical-fill','var(--vert-p)','var(--vert)']][$doc->type] ?? ['bi-file-earmark','#F9FAFB','#6B7280'];
                        @endphp
                        <div class="d-flex align-items-center gap-2">
                            <div class="dtype" style="background:{{ $tc[1] }};color:{{ $tc[2] }};"><i class="bi {{ $tc[0] }}"></i></div>
                            <span style="font-size:.82rem;font-weight:600;color:var(--texte);">{{ $doc->label_type }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:.8rem;color:var(--texte);">{{ $doc->original_name }}</div>
                        <div style="font-size:.71rem;color:#9CA3AF;">{{ $doc->size_formate }}</div>
                    </td>
                    <td style="font-size:.8rem;color:var(--texte-2);">{{ $doc->created_at->format('d/m/Y') }}</td>
                    <td>
                        <button class="bs bs-{{ $doc->status }}"
                                onclick="openModal({{ $doc->id }},'{{ $doc->status }}','{{ addslashes($doc->label_type) }}','{{ addslashes($doc->user->nom_complet??'') }}')">
                            {{ ['en_attente'=>'⏳ En attente','valide'=>'✅ Validé','rejete'=>'❌ Rejeté'][$doc->status] }}
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('admin.documents.download', $doc) }}" class="btn btn-dl" title="Télécharger">
                            <i class="bi bi-download"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#9CA3AF;">
                        <i class="bi bi-folder-x" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                        Aucun document trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $documents->links() }}</div>
</div>

{{-- Modal --}}
<div class="modal fade modal-validate" id="validateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="bi bi-folder-check me-2"></i>Valider / Rejeter le document
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div style="background:var(--bg);border-radius:10px;padding:.75rem 1rem;margin-bottom:1rem;">
                    <div style="font-size:.75rem;color:var(--texte-2);">Document concerné</div>
                    <div style="font-weight:700;color:var(--texte);margin-top:.15rem;" id="modalDocInfo">—</div>
                </div>
                <div class="mb-3">
                    <label style="font-size:.82rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.35rem;">
                        Commentaire <span style="color:var(--texte-2);font-weight:400;">(optionnel)</span>
                    </label>
                    <textarea id="modalCommentaire" class="form-control" rows="3"
                              style="border-radius:10px;font-size:.85rem;border-color:var(--border);"
                              placeholder="Motif de rejet ou note pour l'élève…"></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn-val" onclick="updateStatus('valide')">
                        <i class="bi bi-check-circle-fill me-1"></i>Valider
                    </button>
                    <button class="btn-rej" onclick="updateStatus('rejete')">
                        <i class="bi bi-x-circle-fill me-1"></i>Rejeter
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let currentDocId = null;

function openModal(id, status, type, eleve) {
    currentDocId = id;
    document.getElementById('modalDocInfo').textContent = `${type} — ${eleve}`;
    document.getElementById('modalCommentaire').value = '';
    new bootstrap.Modal(document.getElementById('validateModal')).show();
}

async function updateStatus(status) {
    if (!currentDocId) return;
    const commentaire = document.getElementById('modalCommentaire').value;
    try {
        const res  = await fetch(`/admin/documents/${currentDocId}`, {
            method: 'PATCH',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF, 'Accept':'application/json' },
            body: JSON.stringify({ status, commentaire_admin: commentaire }),
        });
        const data = await res.json();
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('validateModal')).hide();
            const btn = document.querySelector(`button[onclick*="openModal(${currentDocId},"]`);
            if (btn) {
                const labels = { valide:'✅ Validé', rejete:'❌ Rejeté', en_attente:'⏳ En attente' };
                btn.className = `bs bs-${status}`;
                btn.textContent = labels[status];
            }
        }
    } catch(e) { alert('Erreur lors de la mise à jour.'); }
}
</script>
@endsection