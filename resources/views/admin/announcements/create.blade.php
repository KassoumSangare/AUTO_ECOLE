@extends('layouts.app')
@section('title', 'Nouvelle annonce')
@section('page-title', 'Nouvelle annonce')

@section('head')
    <style>
        .form-card {
            background: #fff;
            border-radius: var(--r);
            padding: 2rem;
            border: 1.5px solid var(--border);
            max-width: 640px;
        }

        .lbl {
            font-size: .82rem;
            font-weight: 700;
            color: var(--texte);
            display: block;
            margin-bottom: .4rem;
        }

        .inp {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: .6rem .9rem;
            font-size: .88rem;
            width: 100%;
            transition: .2s;
        }

        .inp:focus {
            border-color: var(--rouge);
            outline: none;
            box-shadow: 0 0 0 3px rgba(175, 38, 54, .1);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--rouge), var(--rouge-c));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .75rem 2rem;
            font-weight: 700;
            font-size: .9rem;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            cursor: pointer;
            transition: .2s;
        }

        .btn-save:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .btn-back {
            background: var(--bg);
            color: var(--texte-2);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: .72rem 1.25rem;
            font-weight: 600;
            font-size: .88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }

        .preview-bar {
            background: linear-gradient(90deg, var(--rouge-c), var(--rouge));
            color: #fff;
            padding: .55rem 1rem;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 600;
            overflow: hidden;
            white-space: nowrap;
            margin-top: .5rem;
        }
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

        <form action="{{ route('admin.announcements.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="lbl">Emoji <span style="color:var(--texte-2);font-weight:400;">(optionnel)</span></label>
                <input type="text" name="emoji" class="inp" value="{{ old('emoji', '🎉') }}" placeholder="🎉 🚗 📢 ⚡"
                    style="max-width:100px;" oninput="updatePreview()">
            </div>

            <div class="mb-3">
                <label class="lbl">Message <span style="color:var(--rouge);">*</span></label>
                <input type="text" name="message" class="inp" value="{{ old('message') }}"
                    placeholder="Ex: Promotion spéciale — 20% de réduction jusqu'au 30 juin !" required maxlength="255"
                    oninput="updatePreview()">
                <div class="preview-bar" id="previewBar" style="margin-top:.5rem;">
                    <span id="previewText">🎉 Votre message apparaîtra ici...</span>
                </div>
            </div>

            <div class="mb-3">
                <label class="lbl">Date & heure d'expiration <span style="color:var(--rouge);">*</span></label>
                <input type="datetime-local" name="expires_at" class="inp" value="{{ old('expires_at') }}" required
                    style="max-width:280px;">
                <small style="color:var(--texte-2);font-size:.76rem;display:block;margin-top:.25rem;">
                    La barre et le compte à rebours disparaissent automatiquement à cette date.
                </small>
            </div>

            <div class="mb-4">
                <label style="display:flex;align-items:center;gap:.6rem;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        style="width:16px;height:16px;accent-color:var(--rouge);">
                    <span class="lbl" style="margin:0;">Activer immédiatement</span>
                </label>
            </div>

            <div class="d-flex gap-2 align-items-center">
                <button type="submit" class="btn-save">
                    <i class="bi bi-megaphone-fill"></i>Publier l'annonce
                </button>
                <a href="{{ route('admin.announcements.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i>Retour
                </a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function updatePreview() {
            const emoji = document.querySelector('[name="emoji"]').value.trim() || '🎉';
            const msg = document.querySelector('[name="message"]').value.trim() || 'Votre message apparaîtra ici...';
            document.getElementById('previewText').textContent = emoji + '  ' + msg;
        }
    </script>
@endsection