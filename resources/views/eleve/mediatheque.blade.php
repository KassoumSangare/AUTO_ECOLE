@extends('layouts.app')
@section('title', 'Médiathèque')
@section('page-title', 'Médiathèque')

@section('head')
<style>
    /* ═══ PALETTE Le Chemin : Variables supplémentaires ══════════ */
    :root {
        --gris-50: #F9FAFB;
        --gris-100: #F3F4F6;
        --gris-200: #E5E7EB;
        --r: 14px;
        --trans: .25s cubic-bezier(.4, 0, .2, 1);
    }

    /* ═══ HEADER SECTION ════════════════════════════════════ */
    .media-header {
        background: linear-gradient(135deg, var(--rouge) 0%, var(--rouge-c) 100%);
        border-radius: 20px;
        padding: 2rem 2.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
        position: relative;
        overflow: hidden;
    }

    .media-header::before {
        content: '';
        position: absolute;
        right: -60px;
        top: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
    }

    .media-header::after {
        content: '';
        position: absolute;
        left: 40%;
        bottom: -40px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
    }

    .media-header-title {
        font-family: 'Syne', sans-serif;
        font-weight: 900;
        font-size: 1.5rem;
        color: #fff;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .media-header-sub {
        color: rgba(255, 255, 255, .78);
        font-size: .88rem;
        margin-top: .25rem;
        position: relative;
        z-index: 1;
    }

    .media-stat-chip {
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 50px;
        padding: .45rem 1rem;
        color: #fff;
        font-size: .82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        position: relative;
        z-index: 1;
    }

    /* ═══ ONGLETS CATÉGORIES ════════════════════════════════ */
    .cat-tabs {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .cat-tab {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .55rem 1.1rem;
        border-radius: 50px;
        font-size: .85rem;
        font-weight: 700;
        border: 2px solid var(--gris-200);
        background: #fff;
        color: var(--texte-2);
        cursor: pointer;
        transition: var(--trans);
    }

    .cat-tab:hover {
        border-color: var(--rouge);
        color: var(--rouge);
    }

    .cat-tab.active {
        background: var(--rouge);
        border-color: var(--rouge);
        color: #fff;
        box-shadow: 0 4px 14px rgba(200, 16, 46, .3);
    }

    .cat-tab.active.vert {
        background: var(--vert);
        border-color: var(--vert);
        box-shadow: 0 4px 14px rgba(0, 154, 68, .3);
    }

    .cat-tab.active.or {
        background: #856404;
        border-color: #856404;
    }

    /* ═══ GRILLE VIDÉOS ══════════════════════════════════════ */
    .video-grid {
        display: none;
    }

    .video-grid.active {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
    }

    .video-card {
        background: #fff;
        border-radius: var(--r);
        border: 1.5px solid var(--gris-200);
        overflow: hidden;
        transition: var(--trans);
        display: flex;
        flex-direction: column;
    }

    .video-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
        border-color: var(--rouge);
    }

    /* Miniature YouTube */
    .video-thumb {
        position: relative;
        padding-top: 56.25%;
        /* 16:9 */
        background: #111;
        cursor: pointer;
        overflow: hidden;
    }

    .video-thumb img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }

    .video-card:hover .video-thumb img {
        transform: scale(1.04);
    }

    .play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(1);
        width: 52px;
        height: 52px;
        background: var(--rouge);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.3rem;
        box-shadow: 0 4px 20px rgba(200, 16, 46, .5);
        transition: transform .25s ease, box-shadow .25s ease;
        z-index: 2;
    }

    .video-card:hover .play-btn {
        transform: translate(-50%, -50%) scale(1.12);
        box-shadow: 0 6px 28px rgba(200, 16, 46, .7);
    }

    .video-duree {
        position: absolute;
        bottom: 8px;
        right: 10px;
        background: rgba(0, 0, 0, .75);
        color: #fff;
        font-size: .72rem;
        font-weight: 700;
        padding: .15rem .5rem;
        border-radius: 4px;
    }

    .video-body {
        padding: 1.1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .video-title {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .93rem;
        color: var(--texte);
        margin-bottom: .4rem;
        line-height: 1.35;
    }

    .video-desc {
        font-size: .8rem;
        color: var(--texte-2);
        line-height: 1.55;
        flex: 1;
    }

    .video-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: .85rem;
        padding-top: .75rem;
        border-top: 1px solid var(--gris-100);
    }

    .btn-watch {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: var(--rouge);
        color: #fff;
        font-size: .8rem;
        font-weight: 700;
        padding: .4rem .9rem;
        border-radius: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: var(--trans);
    }

    .btn-watch:hover {
        background: var(--rouge-c);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-watch.vert {
        background: var(--vert);
    }

    .btn-watch.vert:hover {
        background: var(--vert-c);
    }

    /* ═══ MODALE LECTEUR ════════════════════════════════════ */
    .video-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0, 0, 0, .88);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity .3s ease;
        padding: 1rem;
    }

    .video-modal-overlay.open {
        opacity: 1;
        pointer-events: all;
    }

    .video-modal {
        background: #111;
        border-radius: 16px;
        overflow: hidden;
        width: 100%;
        max-width: 860px;
        transform: scale(.94);
        transition: transform .3s ease;
        box-shadow: 0 24px 60px rgba(0, 0, 0, .6);
    }

    .video-modal-overlay.open .video-modal {
        transform: scale(1);
    }

    .video-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .9rem 1.25rem;
        background: #1a1a1a;
    }

    .video-modal-title {
        color: #fff;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: .95rem;
        margin: 0;
    }

    .modal-close-btn {
        background: rgba(255, 255, 255, .1);
        border: none;
        color: #fff;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background .2s;
        font-size: 1rem;
    }

    .modal-close-btn:hover {
        background: var(--rouge);
    }

    .video-player-wrap {
        position: relative;
        padding-top: 56.25%;
        background: #000;
    }

    .video-player-wrap iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    /* ═══ RESPONSIVE ════════════════════════════════════════ */
    @media (max-width: 575px) {
        .video-grid.active {
            grid-template-columns: 1fr;
        }

        .media-header {
            padding: 1.5rem;
        }

        .media-header-title {
            font-size: 1.2rem;
        }
    }
</style>
@endsection

@section('content')

{{-- ══ HEADER ══ --}}
<div class="media-header">
    <div style="position:relative;z-index:1;">
        <h2 class="media-header-title">
            <i class="bi bi-play-circle-fill me-2" style="color:rgba(255,255,255,.8);"></i>
            Médiathèque de formation
        </h2>
        <p class="media-header-sub">
            Regardez les cours vidéo à votre rythme, autant de fois que nécessaire.
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap" style="position:relative;z-index:1;">
        <div class="media-stat-chip">
            <i class="bi bi-camera-video-fill"></i>
            {{ $totalVideos }} vidéos disponibles
        </div>
        <div class="media-stat-chip">
            <i class="bi bi-clock-fill"></i>
            Accès illimité 24h/7
        </div>
    </div>
</div>

{{-- ══ ONGLETS ══ --}}
<div class="cat-tabs">
    @foreach($playlists as $key => $playlist)
    @php
    $colorClass = $key === 'conduite' ? 'vert' : ($key === 'securite' ? 'or' : '');
    @endphp
    <button class="cat-tab {{ $key === 'code' ? 'active' : '' }} {{ $colorClass }}"
        onclick="showCategory('{{ $key }}', this, '{{ $colorClass }}')"
        data-key="{{ $key }}">
        <i class="bi {{ $playlist['icone'] }}"></i>
        {{ $playlist['titre'] }}
        <span style="background:rgba(255,255,255,.25);border-radius:50px;padding:.1rem .5rem;font-size:.75rem;">
            {{ count($playlist['videos']) }}
        </span>
    </button>
    @endforeach
</div>

{{-- ══ GRILLES VIDÉOS ══ --}}
@foreach($playlists as $key => $playlist)
@php $colorClass = $key === 'conduite' ? 'vert' : ($key === 'securite' ? 'or' : ''); @endphp
<div class="video-grid {{ $key === 'code' ? 'active' : '' }}" id="grid-{{ $key }}">
    @foreach($playlist['videos'] as $video)
    <div class="video-card">
        {{-- Miniature --}}
        <div class="video-thumb"
            onclick="openVideo('{{ $video['id'] }}', '{{ addslashes($video['titre']) }}')">
            <img src="https://img.youtube.com/vi/{{ $video['id'] }}/hqdefault.jpg"
                alt="{{ $video['titre'] }}"
                loading="lazy">
            <div class="play-btn">
                <i class="bi bi-play-fill" style="margin-left:3px;"></i>
            </div>
            <div class="video-duree">{{ $video['duree'] }}</div>
        </div>

        <div class="video-body">
            <div class="video-title">{{ $video['titre'] }}</div>
            <p class="video-desc">{{ $video['description'] }}</p>

            <div class="video-footer">
                <span style="font-size:.75rem;color:var(--texte-2);">
                    <i class="bi bi-clock me-1"></i>{{ $video['duree'] }}
                </span>
                <button class="btn-watch {{ $colorClass }}"
                    onclick="openVideo('{{ $video['id'] }}', '{{ addslashes($video['titre']) }}')">
                    <i class="bi bi-play-fill"></i> Regarder
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach

{{-- ══ MODALE LECTEUR ══ --}}
<div class="video-modal-overlay" id="videoModal" onclick="handleOverlayClick(event)">
    <div class="video-modal" id="videoModalBox">
        <div class="video-modal-header">
            <h3 class="video-modal-title" id="modalTitle">Chargement…</h3>
            <button class="modal-close-btn" onclick="closeVideo()" aria-label="Fermer">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="video-player-wrap">
            <iframe id="videoFrame"
                src=""
                allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
            </iframe>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    /* ── Changer de catégorie ────────────────────── */
    function showCategory(key, btn, colorClass) {
        // Masquer toutes les grilles
        document.querySelectorAll('.video-grid').forEach(g => g.classList.remove('active'));
        // Désactiver tous les onglets
        document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
        // Activer la bonne grille
        document.getElementById('grid-' + key).classList.add('active');
        // Activer l'onglet cliqué
        btn.classList.add('active');
        if (colorClass) btn.classList.add(colorClass);
    }

    /* ── Ouvrir la modale ────────────────────────── */
    function openVideo(youtubeId, titre) {
        const modal = document.getElementById('videoModal');
        const frame = document.getElementById('videoFrame');
        const title = document.getElementById('modalTitle');

        title.textContent = titre;
        frame.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0&modestbranding=1`;

        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    /* ── Fermer la modale ────────────────────────── */
    function closeVideo() {
        const modal = document.getElementById('videoModal');
        const frame = document.getElementById('videoFrame');

        modal.classList.remove('open');
        frame.src = ''; // Arrêter la vidéo
        document.body.style.overflow = '';
    }

    /* Fermer si clic sur le fond sombre */
    function handleOverlayClick(e) {
        if (e.target === document.getElementById('videoModal')) closeVideo();
    }

    /* Fermer avec Echap */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeVideo();
    });
</script>
@endsection@extends('layouts.app')
@section('title', 'Médiathèque')
@section('page-title', 'Médiathèque')

@section('head')
<style>
/* ═══ HEADER SECTION ════════════════════════════════════ */
.media-header {
    background: linear-gradient(135deg, var(--rouge) 0%, var(--rouge-c) 100%);
    border-radius: 20px; padding: 2rem 2.25rem;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 1rem; margin-bottom: 1.75rem;
    position: relative; overflow: hidden;
}
.media-header::before {
    content: ''; position: absolute; right: -60px; top: -60px;
    width: 220px; height: 220px; border-radius: 50%;
    background: rgba(255,255,255,.07);
}
.media-header::after {
    content: ''; position: absolute; left: 40%; bottom: -40px;
    width: 140px; height: 140px; border-radius: 50%;
    background: rgba(255,255,255,.05);
}
.media-header-title {
    font-family: 'Syne', sans-serif; font-weight: 900;
    font-size: 1.5rem; color: #fff; margin: 0;
    position: relative; z-index: 1;
}
.media-header-sub  { color: rgba(255,255,255,.78); font-size: .88rem; margin-top: .25rem; position: relative; z-index:1;}
.media-stat-chip {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 50px; padding: .45rem 1rem;
    color: #fff; font-size: .82rem; font-weight: 600;
    display: inline-flex; align-items: center; gap: .4rem;
    position: relative; z-index: 1;
}

/* ═══ ONGLETS CATÉGORIES ════════════════════════════════ */
.cat-tabs {
    display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.5rem;
}
.cat-tab {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .55rem 1.1rem; border-radius: 50px;
    font-size: .85rem; font-weight: 700;
    border: 2px solid var(--gris-200);
    background: #fff; color: var(--texte-2);
    cursor: pointer; transition: var(--trans);
}
.cat-tab:hover { border-color: var(--rouge); color: var(--rouge); }
.cat-tab.active {
    background: var(--rouge); border-color: var(--rouge);
    color: #fff; box-shadow: 0 4px 14px rgba(200,16,46,.3);
}
.cat-tab.active.vert { background: var(--vert); border-color: var(--vert); box-shadow: 0 4px 14px rgba(0,154,68,.3); }
.cat-tab.active.or   { background: #78350F;    border-color: #78350F; }

/* ═══ GRILLE VIDÉOS ══════════════════════════════════════ */
.video-grid { display: none; }
.video-grid.active { display: grid; grid-template-columns: repeat(auto-fill,minmax(280px,1fr)); gap: 1.25rem; }

.video-card {
    background: #fff; border-radius: var(--r);
    border: 1.5px solid var(--gris-200); overflow: hidden;
    transition: var(--trans);
    display: flex; flex-direction: column;
}
.video-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,.1); border-color: var(--rouge); }

/* Miniature YouTube */
.video-thumb {
    position: relative; padding-top: 56.25%; /* 16:9 */
    background: #111; cursor: pointer; overflow: hidden;
}
.video-thumb img {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; transition: transform .4s ease;
}
.video-card:hover .video-thumb img { transform: scale(1.04); }

.play-btn {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%,-50%) scale(1);
    width: 52px; height: 52px;
    background: var(--rouge); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.3rem;
    box-shadow: 0 4px 20px rgba(200,16,46,.5);
    transition: transform .25s ease, box-shadow .25s ease;
    z-index: 2;
}
.video-card:hover .play-btn { transform: translate(-50%,-50%) scale(1.12); box-shadow: 0 6px 28px rgba(200,16,46,.7); }

.video-duree {
    position: absolute; bottom: 8px; right: 10px;
    background: rgba(0,0,0,.75); color: #fff;
    font-size: .72rem; font-weight: 700;
    padding: .15rem .5rem; border-radius: 4px;
}

.video-body { padding: 1.1rem; flex: 1; display: flex; flex-direction: column; }
.video-title {
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: .93rem; color: var(--texte);
    margin-bottom: .4rem; line-height: 1.35;
}
.video-desc  { font-size: .8rem; color: var(--texte-2); line-height: 1.55; flex: 1; }
.video-footer {
    display: flex; align-items: center; justify-content: space-between;
    margin-top: .85rem; padding-top: .75rem;
    border-top: 1px solid var(--gris-100);
}
.btn-watch {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--rouge); color: #fff;
    font-size: .8rem; font-weight: 700;
    padding: .4rem .9rem; border-radius: 8px;
    text-decoration: none; border: none; cursor: pointer;
    transition: var(--trans);
}
.btn-watch:hover { background: var(--rouge-c); color: #fff; transform: translateY(-1px); }
.btn-watch.vert  { background: var(--vert); }
.btn-watch.vert:hover { background: var(--vert-c); }

/* ═══ MODALE LECTEUR ════════════════════════════════════ */
.video-modal-overlay {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,.88);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity .3s ease;
    padding: 1rem;
}
.video-modal-overlay.open { opacity: 1; pointer-events: all; }

.video-modal {
    background: #111; border-radius: 16px; overflow: hidden;
    width: 100%; max-width: 860px;
    transform: scale(.94); transition: transform .3s ease;
    box-shadow: 0 24px 60px rgba(0,0,0,.6);
}
.video-modal-overlay.open .video-modal { transform: scale(1); }

.video-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: .9rem 1.25rem; background: #1a1a1a;
}
.video-modal-title { color: #fff; font-family: 'Syne', sans-serif; font-weight: 700; font-size: .95rem; margin: 0; }
.modal-close-btn {
    background: rgba(255,255,255,.1); border: none; color: #fff;
    width: 34px; height: 34px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .2s; font-size: 1rem;
}
.modal-close-btn:hover { background: var(--rouge); }

.video-player-wrap {
    position: relative; padding-top: 56.25%; background: #000;
}
.video-player-wrap iframe {
    position: absolute; inset: 0; width: 100%; height: 100%; border: none;
}

/* ═══ RESPONSIVE ════════════════════════════════════════ */
@media (max-width: 575px) {
    .video-grid.active { grid-template-columns: 1fr; }
    .media-header { padding: 1.5rem; }
    .media-header-title { font-size: 1.2rem; }
}
</style>
@endsection

@section('content')

{{-- ══ HEADER ══ --}}
<div class="media-header">
    <div style="position:relative;z-index:1;">
        <h2 class="media-header-title">
            <i class="bi bi-play-circle-fill me-2" style="color:rgba(255,255,255,.8);"></i>
            Médiathèque de formation
        </h2>
        <p class="media-header-sub">
            Regardez les cours vidéo à votre rythme, autant de fois que nécessaire.
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap" style="position:relative;z-index:1;">
        <div class="media-stat-chip">
            <i class="bi bi-camera-video-fill"></i>
            {{ $totalVideos }} vidéos disponibles
        </div>
        <div class="media-stat-chip">
            <i class="bi bi-clock-fill"></i>
            Accès illimité 24h/7
        </div>
    </div>
</div>

{{-- ══ ONGLETS ══ --}}
<div class="cat-tabs">
    @foreach($playlists as $key => $playlist)
    @php
        $colorClass = $key === 'conduite' ? 'vert' : ($key === 'securite' ? 'or' : '');
    @endphp
    <button class="cat-tab {{ $key === 'code' ? 'active' : '' }} {{ $colorClass }}"
            onclick="showCategory('{{ $key }}', this, '{{ $colorClass }}')"
            data-key="{{ $key }}">
        <i class="bi {{ $playlist['icone'] }}"></i>
        {{ $playlist['titre'] }}
        <span style="background:rgba(255,255,255,.25);border-radius:50px;padding:.1rem .5rem;font-size:.75rem;">
            {{ count($playlist['videos']) }}
        </span>
    </button>
    @endforeach
</div>

{{-- ══ GRILLES VIDÉOS ══ --}}
@foreach($playlists as $key => $playlist)
@php $colorClass = $key === 'conduite' ? 'vert' : ($key === 'securite' ? 'or' : ''); @endphp
<div class="video-grid {{ $key === 'code' ? 'active' : '' }}" id="grid-{{ $key }}">
    @foreach($playlist['videos'] as $video)
    <div class="video-card">
        {{-- Miniature --}}
        <div class="video-thumb"
             onclick="openVideo('{{ $video['id'] }}', '{{ addslashes($video['titre']) }}')">
            <img src="https://img.youtube.com/vi/{{ $video['id'] }}/hqdefault.jpg"
                 alt="{{ $video['titre'] }}"
                 loading="lazy">
            <div class="play-btn">
                <i class="bi bi-play-fill" style="margin-left:3px;"></i>
            </div>
            <div class="video-duree">{{ $video['duree'] }}</div>
        </div>

        <div class="video-body">
            <div class="video-title">{{ $video['titre'] }}</div>
            <p class="video-desc">{{ $video['description'] }}</p>

            <div class="video-footer">
                <span style="font-size:.75rem;color:var(--texte-2);">
                    <i class="bi bi-clock me-1"></i>{{ $video['duree'] }}
                </span>
                <button class="btn-watch {{ $colorClass }}"
                        onclick="openVideo('{{ $video['id'] }}', '{{ addslashes($video['titre']) }}')">
                    <i class="bi bi-play-fill"></i> Regarder
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach

{{-- ══ MODALE LECTEUR ══ --}}
<div class="video-modal-overlay" id="videoModal" onclick="handleOverlayClick(event)">
    <div class="video-modal" id="videoModalBox">
        <div class="video-modal-header">
            <h3 class="video-modal-title" id="modalTitle">Chargement…</h3>
            <button class="modal-close-btn" onclick="closeVideo()" aria-label="Fermer">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="video-player-wrap">
            <iframe id="videoFrame"
                    src=""
                    allowfullscreen
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
            </iframe>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
/* ── Changer de catégorie ────────────────────── */
function showCategory(key, btn, colorClass) {
    // Masquer toutes les grilles
    document.querySelectorAll('.video-grid').forEach(g => g.classList.remove('active'));
    // Désactiver tous les onglets
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    // Activer la bonne grille
    document.getElementById('grid-' + key).classList.add('active');
    // Activer l'onglet cliqué
    btn.classList.add('active');
    if (colorClass) btn.classList.add(colorClass);
}

/* ── Ouvrir la modale ────────────────────────── */
function openVideo(youtubeId, titre) {
    const modal = document.getElementById('videoModal');
    const frame = document.getElementById('videoFrame');
    const title = document.getElementById('modalTitle');

    title.textContent = titre;
    frame.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0&modestbranding=1`;

    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
}

/* ── Fermer la modale ────────────────────────── */
function closeVideo() {
    const modal = document.getElementById('videoModal');
    const frame = document.getElementById('videoFrame');

    modal.classList.remove('open');
    frame.src = ''; // Arrêter la vidéo
    document.body.style.overflow = '';
}

/* Fermer si clic sur le fond sombre */
function handleOverlayClick(e) {
    if (e.target === document.getElementById('videoModal')) closeVideo();
}

/* Fermer avec Echap */
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeVideo(); });
</script>
@endsection