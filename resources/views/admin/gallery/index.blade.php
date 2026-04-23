@extends('layouts.app')
@section('title', 'Galerie photos')
@section('page-title', 'Galerie photos')

@section('head')
    <style>
        .card-a {
            background: #fff;
            border-radius: var(--r);
            padding: 1.4rem;
            border: 1.5px solid var(--border);
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .photo-item {
            border-radius: 12px;
            overflow: hidden;
            border: 1.5px solid var(--border);
            background: #fff;
            transition: .2s ease;
        }

        .photo-item:hover {
            box-shadow: 0 8px 24px rgba(175, 38, 54, .12);
            transform: translateY(-2px);
        }

        .photo-thumb {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
        }

        .photo-body {
            padding: .75rem;
        }

        .photo-title {
            font-weight: 700;
            font-size: .84rem;
            color: var(--texte);
            margin-bottom: .25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cat-badge {
            font-size: .7rem;
            font-weight: 700;
            padding: .2rem .6rem;
            border-radius: 50px;
        }

        .photo-actions {
            display: flex;
            gap: .4rem;
            margin-top: .6rem;
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
            transition: .2s ease;
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
        <span style="font-size:.85rem;color:var(--texte-2);">{{ $photos->total() }} photo(s)</span>
        <a href="{{ route('admin.gallery.create') }}" class="btn-add">
            <i class="bi bi-plus-circle-fill"></i>Ajouter une photo
        </a>
    </div>

    <div class="card-a">
        @if($photos->isEmpty())
            <div class="text-center py-5" style="color:#9CA3AF;">
                <i class="bi bi-images" style="font-size:2.5rem;display:block;margin-bottom:.75rem;"></i>
                Aucune photo dans la galerie. <a href="{{ route('admin.gallery.create') }}">Ajouter la première</a>.
            </div>
        @else
            <div class="photo-grid">
                @foreach($photos as $photo)
                    <div class="photo-item {{ !$photo->is_active ? 'opacity-50' : '' }}">
                        <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" class="photo-thumb" loading="lazy">
                        <div class="photo-body">
                            <div class="photo-title" title="{{ $photo->title }}">{{ $photo->title }}</div>
                            @php
                                $colors = ['seance' => ['#FFF1F2', '#AF2636'], 'moniteur' => ['#F0F7F4', '#2D6A4F'], 'voiture' => ['#FEFCE8', '#92400E'], 'autre' => ['#EFF6FF', '#1D4ED8']];
                                [$bg, $c] = $colors[$photo->category] ?? ['#F3F4F6', '#374151'];
                            @endphp
                            <span class="cat-badge" style="background:{{ $bg }};color:{{ $c }};">
                                {{ $photo->category_label }}
                            </span>
                            <div class="photo-actions">
                                {{-- Toggle actif --}}
                                <form action="{{ route('admin.gallery.toggle', $photo) }}" method="POST" style="flex:1;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm w-100"
                                        style="border-radius:7px;font-size:.74rem;border:none;background:{{ $photo->is_active ? 'var(--vert-p)' : '#F3F4F6' }};color:{{ $photo->is_active ? 'var(--vert)' : '#6B7280' }};">
                                        {{ $photo->is_active ? '✅ Visible' : '🔒 Masqué' }}
                                    </button>
                                </form>
                                {{-- Supprimer --}}
                                <form action="{{ route('admin.gallery.destroy', $photo) }}" method="POST"
                                    onsubmit="return confirm('Supprimer cette photo ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                        style="border-radius:7px;font-size:.74rem;border:none;background:var(--rouge-p);color:var(--rouge);">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $photos->links() }}</div>
        @endif
    </div>

@endsection