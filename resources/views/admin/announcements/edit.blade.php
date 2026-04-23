@extends('layouts.app')
@section('title', 'Modifier l\'annonce')
@section('page-title', 'Modifier l\'annonce')

@section('head')
<style>
.form-card { background:#fff; border-radius:var(--r); padding:2rem; border:1.5px solid var(--border); max-width:640px; }
.lbl { font-size:.82rem; font-weight:700; color:var(--texte); display:block; margin-bottom:.4rem; }
.inp { border:1.5px solid var(--border); border-radius:10px; padding:.6rem .9rem; font-size:.88rem; width:100%; transition:.2s; }
.inp:focus { border-color:var(--rouge); outline:none; box-shadow:0 0 0 3px rgba(175,38,54,.1); }
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

    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="lbl">Emoji</label>
            <input type="text" name="emoji" class="inp" value="{{ old('emoji', $announcement->emoji) }}"
                   style="max-width:100px;">
        </div>

        <div class="mb-3">
            <label class="lbl">Message <span style="color:var(--rouge);">*</span></label>
            <input type="text" name="message" class="inp"
                   value="{{ old('message', $announcement->message) }}"
                   required maxlength="255">
        </div>

        <div class="mb-3">
            <label class="lbl">Date & heure d'expiration <span style="color:var(--rouge);">*</span></label>
            <input type="datetime-local" name="expires_at" class="inp"
                   value="{{ old('expires_at', $announcement->expires_at->format('Y-m-d\TH:i')) }}"
                   required style="max-width:280px;">
        </div>

        <div class="mb-4">
            <label style="display:flex;align-items:center;gap:.6rem;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}
                       style="width:16px;height:16px;accent-color:var(--rouge);">
                <span class="lbl" style="margin:0;">Annonce active</span>
            </label>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <button type="submit" class="btn-save">
                <i class="bi bi-check-circle-fill"></i>Enregistrer
            </button>
            <a href="{{ route('admin.announcements.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>Retour
            </a>
        </div>
    </form>
</div>
@endsection