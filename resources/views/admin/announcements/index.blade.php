@extends('layouts.app')
@section('title', 'Annonces')
@section('page-title', 'Annonces & Barre d\'info')

@section('head')
    <style>
        .card-a {
            background: #fff;
            border-radius: var(--r);
            padding: 1.4rem;
            border: 1.5px solid var(--border);
        }

        .ann-row {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg);
            border-radius: 12px;
            margin-bottom: .75rem;
            border: 1.5px solid var(--border);
            transition: .2s;
        }

        .ann-row:hover {
            border-color: var(--rouge);
            background: #fff;
        }

        .ann-emoji {
            font-size: 1.8rem;
            flex-shrink: 0;
            line-height: 1;
        }

        .ann-msg {
            font-weight: 700;
            font-size: .9rem;
            color: var(--texte);
            margin-bottom: .2rem;
        }

        .ann-meta {
            font-size: .76rem;
            color: var(--texte-2);
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .badge-active {
            background: var(--vert-p);
            color: var(--vert-c);
            font-size: .72rem;
            font-weight: 700;
            padding: .22rem .65rem;
            border-radius: 50px;
        }

        .badge-inactive {
            background: #F3F4F6;
            color: #6B7280;
            font-size: .72rem;
            font-weight: 700;
            padding: .22rem .65rem;
            border-radius: 50px;
        }

        .badge-expired {
            background: #FFF1F2;
            color: var(--rouge);
            font-size: .72rem;
            font-weight: 700;
            padding: .22rem .65rem;
            border-radius: 50px;
        }

        .btn-add {
            background: linear-gradient(135deg, var(--rouge), var(--rouge-c));
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

        .btn-add:hover {
            opacity: .9;
            color: #fff;
            transform: translateY(-1px);
        }
    </style>
@endsection

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-3">
        <span style="font-size:.85rem;color:var(--texte-2);">{{ $announcements->count() }} annonce(s)</span>
        <a href="{{ route('admin.announcements.create') }}" class="btn-add">
            <i class="bi bi-plus-circle-fill"></i>Nouvelle annonce
        </a>
    </div>

    <div class="card-a">
        @forelse($announcements as $ann)
            <div class="ann-row">
                <div class="ann-emoji">{{ $ann->emoji }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="ann-msg">{{ $ann->message }}</div>
                    <div class="ann-meta">
                        <span><i class="bi bi-clock me-1"></i>Expire le {{ $ann->expires_at->format('d/m/Y à H:i') }}</span>
                        @if(!$ann->is_active)
                            <span class="badge-inactive">🔒 Désactivée</span>
                        @elseif($ann->expires_at->isPast())
                            <span class="badge-expired">⏰ Expirée</span>
                        @else
                            <span class="badge-active">✅ Active</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-1 flex-shrink-0">
                    {{-- Toggle --}}
                    <form action="{{ route('admin.announcements.toggle', $ann) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm"
                            style="border-radius:8px;font-size:.75rem;border:none;background:{{ $ann->is_active ? 'var(--vert-p)' : '#F3F4F6' }};color:{{ $ann->is_active ? 'var(--vert)' : '#6B7280' }};">
                            {{ $ann->is_active ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                    {{-- Éditer --}}
                    <a href="{{ route('admin.announcements.edit', $ann) }}" class="btn btn-sm"
                        style="border-radius:8px;font-size:.75rem;border:none;background:var(--rouge-p);color:var(--rouge);">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    {{-- Supprimer --}}
                    <form action="{{ route('admin.announcements.destroy', $ann) }}" method="POST"
                        onsubmit="return confirm('Supprimer cette annonce ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm"
                            style="border-radius:8px;font-size:.75rem;border:none;background:#FEF2F2;color:#DC2626;">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5" style="color:#9CA3AF;">
                <i class="bi bi-megaphone" style="font-size:2.5rem;display:block;margin-bottom:.75rem;"></i>
                Aucune annonce. <a href="{{ route('admin.announcements.create') }}">Créer la première</a>.
            </div>
        @endforelse
    </div>

@endsection