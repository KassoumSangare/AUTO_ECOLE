@extends('layouts.app')
@section('title', 'Ajouter une photo')
@section('page-title', 'Ajouter une photo')

@section('head')
<style>
.form-card { background:#fff; border-radius:var(--r); padding:2rem; border:1.5px solid var(--border); max-width:600px; }
.lbl { font-size:.82rem; font-weight:700; color:var(--texte); display:block; margin-bottom:.4rem; }
.inp { border:1.5px solid var(--border); border-radius:10px; padding:.6rem .9rem; font-size:.88rem; width:100%; transition:.2s; }
.inp:focus { border-color:var(--rouge); outline:none; box-shadow:0 0 0 3px rgba(175,38,54,.1); }
.drop-zone { border:2px dashed var(--border); border-radius:14px; padding:2.5rem 1.5rem; text-align:center; cursor:pointer; transition:.25s; background:var(--bg); }
.drop-zone:hover, .drop-zone.drag-over { border-color:var(--rouge); background:var(--rouge-p); }
.drop-zone i { font-size:2rem; color:var(--texte-2); display:block; margin-bottom:.5rem; }
#imagePreview { width:100%; max-height:240px; object-fit:cover; border-radius:10px; display:none; margin-top:1rem; }
.btn-save { background:linear-gradient(135deg,var(--rouge),var(--rouge-c)); color:#fff; border:none; border-radius:10px; padding:.75rem 2rem; font-weight:700; font-size:.9rem; display:inline-flex; align-items:center; gap:.5rem; cursor:pointer; transition:.2s; }
.btn-save:hover { opacity:.9; transform:translateY(-1px); }
.btn-back { background:var(--bg); color:var(--texte-2); border:1.5px solid var(--border); border-radius:10px; padding:.72rem 1.25rem; font-weight:600; font-size:.88rem; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem; }
</style>
@endsection

@section('content')
<div class="form-card">
    @if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0 ps-3" style="font-size:.85rem;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="lbl">Titre <span style="color:var(--rouge);">*</span></label>
            <input type="text" name="title" class="inp" value="{{ old('title') }}"
                   placeholder="Ex: Séance du 15 avril" required>
        </div>

        <div class="mb-3">
            <label class="lbl">Catégorie <span style="color:var(--rouge);">*</span></label>
            <select name="category" class="inp" required>
                <option value="">— Choisir —</option>
                @foreach($categories as $key => $label)
                <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="lbl">Ordre d'affichage</label>
            <input type="number" name="order" class="inp" value="{{ old('order', 0) }}" min="0" style="max-width:120px;">
            <small style="color:var(--texte-2);font-size:.76rem;">0 = en premier</small>
        </div>

        <div class="mb-4">
            <label class="lbl">Image <span style="color:var(--rouge);">*</span></label>
            <div class="drop-zone" id="dropZone" onclick="document.getElementById('imageInput').click()">
                <i class="bi bi-cloud-arrow-up-fill"></i>
                <div style="font-weight:700;font-size:.9rem;color:var(--texte);">Cliquez ou glissez votre image ici</div>
                <div style="font-size:.78rem;color:var(--texte-2);margin-top:.3rem;">JPG, PNG, WebP — max 4 Mo</div>
            </div>
            <input type="file" id="imageInput" name="image" accept=".jpg,.jpeg,.png,.webp"
                   style="display:none;" required>
            <img id="imagePreview" src="" alt="Aperçu">
        </div>

        <div class="d-flex gap-2 align-items-center">
            <button type="submit" class="btn-save">
                <i class="bi bi-cloud-upload-fill"></i>Enregistrer
            </button>
            <a href="{{ route('admin.gallery.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>Retour
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
const input    = document.getElementById('imageInput');
const preview  = document.getElementById('imagePreview');
const dropZone = document.getElementById('dropZone');

input.addEventListener('change', function () {
    showPreview(this.files[0]);
});

['dragover','dragleave','drop'].forEach(evt => {
    dropZone.addEventListener(evt, function (e) {
        e.preventDefault();
        if (evt === 'dragover')  dropZone.classList.add('drag-over');
        if (evt === 'dragleave') dropZone.classList.remove('drag-over');
        if (evt === 'drop') {
            dropZone.classList.remove('drag-over');
            const file = e.dataTransfer.files[0];
            if (file) {
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                showPreview(file);
            }
        }
    });
});

function showPreview(file) {
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
}
</script>
@endsection