@extends('layouts.app')
@section('title', 'Mes Documents')
@section('page-title', 'Coffre-fort numérique')

@section('head')
<style>
.doc-card { background:#fff; border-radius:var(--r); border:1.5px solid var(--border); padding:1.5rem; transition:.25s ease; }
.doc-card:hover { box-shadow:0 8px 24px rgba(0,0,0,.08); }

.upload-zone {
    border:2px dashed var(--border); border-radius:14px;
    padding:2rem; text-align:center; cursor:pointer;
    transition:.25s ease; background:var(--bg);
}
.upload-zone:hover, .upload-zone.dragover { border-color:var(--rouge); background:var(--rouge-p); }
.upload-zone input[type=file] { display:none; }
.upload-zone .icon { font-size:2.2rem; color:#9CA3AF; margin-bottom:.5rem; }
.upload-zone .upload-label { color:var(--rouge); font-weight:700; cursor:pointer; }

.checklist-item { display:flex; align-items:center; gap:.75rem; padding:.6rem .75rem; border-radius:10px; font-size:.88rem; margin-bottom:.4rem; }
.checklist-item.done    { background:var(--vert-p); color:var(--vert-c); }
.checklist-item.missing { background:#FEFCE8; color:#78350F; }

.btn-submit-doc {
    background:linear-gradient(135deg,var(--rouge),var(--rouge-c));
    color:#fff; border:none; border-radius:10px;
    padding:.75rem 1.5rem; font-family:'Syne',sans-serif;
    font-weight:800; width:100%; transition:.25s ease;
}
.btn-submit-doc:hover { opacity:.9; transform:translateY(-1px); color:#fff; }

.doc-type-icon { width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0; }
.bs { font-size:.75rem; font-weight:700; padding:.3rem .7rem; border-radius:50px; }
.bs-att { background:#FEFCE8; color:#78350F; }
.bs-val { background:var(--vert-p); color:var(--vert-c); }
.bs-rej { background:var(--rouge-p); color:var(--rouge-c); }

.btn-dl  { background:var(--bg); color:var(--texte); border-radius:8px; font-size:.78rem; border:1.5px solid var(--border); }
.btn-del { background:var(--rouge-p); color:var(--rouge); border-radius:8px; font-size:.78rem; border:none; }
</style>
@endsection

@section('content')
<div class="row g-4">

    {{-- ── Upload ── --}}
    <div class="col-lg-5">
        <div class="doc-card">
            <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1.25rem;">
                <i class="bi bi-cloud-arrow-up-fill me-2" style="color:var(--rouge);"></i>Déposer un document
            </h6>

            @if($errors->any())
            <div class="alert py-2 px-3 mb-3" style="border-radius:10px;font-size:.88rem;background:var(--rouge-p);border:1px solid rgba(200,16,46,.2);color:var(--rouge-c);">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('eleve.documents.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label style="font-size:.84rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.35rem;">Type de document</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" style="border-radius:10px;border-color:var(--border);">
                        <option value="">-- Choisir le type --</option>
                        @foreach(App\Models\Document::LABELS_TYPE as $val => $label)
                        <option value="{{ $val }}" {{ old('type')===$val?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label style="font-size:.84rem;font-weight:700;color:var(--texte);display:block;margin-bottom:.35rem;">Fichier</label>
                    <div class="upload-zone" id="dropZone" onclick="document.getElementById('fichierInput').click()">
                        <div class="icon" id="dropIcon"><i class="bi bi-file-earmark-arrow-up"></i></div>
                        <div id="dropText">
                            <span class="upload-label">Cliquez pour choisir</span> ou glissez ici
                        </div>
                        <div class="mt-2" style="font-size:.78rem;color:#9CA3AF;">PDF, JPG, PNG — max 5 Mo</div>
                        <input type="file" id="fichierInput" name="fichier" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    @error('fichier')<div style="font-size:.82rem;color:var(--rouge);margin-top:.25rem;">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-submit-doc">
                    <i class="bi bi-send-fill me-2"></i>Soumettre le document
                </button>
            </form>
        </div>

        <div class="doc-card mt-3">
            <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1rem;">
                <i class="bi bi-list-check me-2" style="color:var(--vert);"></i>Documents requis
            </h6>
            @foreach(App\Models\Document::LABELS_TYPE as $type => $label)
            @php $done = !in_array($type, $typesManquants); @endphp
            <div class="checklist-item {{ $done?'done':'missing' }}">
                <i class="bi bi-{{ $done?'check-circle-fill':'clock' }}"></i>
                <span>{{ $label }}</span>
                @if(!$done)<span class="ms-auto" style="font-size:.75rem;opacity:.7;">En attente</span>@endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Liste documents ── --}}
    <div class="col-lg-7">
        <div class="doc-card">
            <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1.25rem;">
                <i class="bi bi-folder2-open me-2" style="color:var(--rouge);"></i>
                Mes documents déposés
                <span class="badge ms-2" style="background:var(--bg);color:var(--texte-2);font-size:.78rem;">{{ $documents->count() }}</span>
            </h6>

            @forelse($documents as $doc)
            <div class="d-flex align-items-center gap-3 p-3 mb-2" style="border-radius:12px;border:1.5px solid var(--border);background:var(--bg);">
                @php
                $iconCfg = [
                    'cni'        => ['bi-person-badge-fill', 'var(--rouge-p)', 'var(--rouge)'],
                    'photo'      => ['bi-image-fill',        '#FEFCE8',        '#78350F'],
                    'certificat' => ['bi-file-medical-fill', 'var(--vert-p)',  'var(--vert)'],
                ][$doc->type] ?? ['bi-file-earmark-fill','#F9FAFB','#6B7280'];
                @endphp
                <div class="doc-type-icon" style="background:{{ $iconCfg[1] }};color:{{ $iconCfg[2] }};"><i class="bi {{ $iconCfg[0] }}"></i></div>
                <div class="flex-grow-1 min-width-0">
                    <div style="font-weight:700;font-size:.9rem;color:var(--texte);">{{ $doc->label_type }}</div>
                    <div style="font-size:.78rem;color:#9CA3AF;">{{ $doc->original_name }} · {{ $doc->size_formate }} · {{ $doc->created_at->format('d/m/Y') }}</div>
                    @if($doc->commentaire_admin)
                    <div class="mt-1" style="font-size:.78rem;color:var(--rouge);"><i class="bi bi-info-circle me-1"></i>{{ $doc->commentaire_admin }}</div>
                    @endif
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    <span class="bs bs-{{ $doc->status }}">{{ ['en_attente'=>'⏳ En attente','valide'=>'✅ Validé','rejete'=>'❌ Rejeté'][$doc->status] }}</span>
                    <div class="d-flex gap-1">
                        <a href="{{ route('eleve.documents.download', $doc) }}" class="btn btn-sm btn-dl"><i class="bi bi-download"></i></a>
                        @if($doc->status !== 'valide')
                        <form method="POST" action="{{ route('eleve.documents.destroy', $doc) }}" onsubmit="return confirm('Supprimer ce document ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-del"><i class="bi bi-trash3"></i></button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-folder-x" style="font-size:2.5rem;color:#CBD5E1;"></i>
                <p class="text-muted mt-2" style="font-size:.9rem;">Aucun document déposé. Commencez par la CNI.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
const dropZone=document.getElementById('dropZone'), fileInput=document.getElementById('fichierInput');
const dropIcon=document.getElementById('dropIcon'), dropText=document.getElementById('dropText');
fileInput.addEventListener('change',()=>updateLabel(fileInput.files[0]));
dropZone.addEventListener('dragover',e=>{e.preventDefault();dropZone.classList.add('dragover');});
dropZone.addEventListener('dragleave',()=>dropZone.classList.remove('dragover'));
dropZone.addEventListener('drop',e=>{e.preventDefault();dropZone.classList.remove('dragover');if(e.dataTransfer.files.length){fileInput.files=e.dataTransfer.files;updateLabel(e.dataTransfer.files[0]);}});
function updateLabel(file){if(!file)return;dropIcon.innerHTML='<i class="bi bi-file-earmark-check-fill" style="color:var(--vert);font-size:2.2rem;"></i>';dropText.innerHTML=`<strong style="color:var(--vert);">${file.name}</strong>`;}
</script>
@endsection