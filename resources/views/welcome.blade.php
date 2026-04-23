@extends('layouts.guest')
@section('title', 'Accueil — Auto-École Le Chemin')

@section('head')
<style>

    /* ══════════════════════════════════════════════════
       PALETTE & VARIABLES
    ══════════════════════════════════════════════════ */
    :root {
        --rouge:   #AF2636;
        --rouge-c: #8A1E2B;
        --rouge-p: #FFF1F2;
        --vert:    #2D6A4F;
        --vert-c:  #1B4332;
        --vert-p:  #F0F7F4;
        --or:      #C5A059;
        --or-c:    #D9B36A;
        --or-p:    #FEFCE8;
        --texte:   #1F2937;
        --texte-2: #6B7280;
        --border:  #E5E7EB;
        --fond:    #FBFBF9;
        --bg:      #F5F5F3;
        --font-d:  'Montserrat', sans-serif;
        --font-b:  'Open Sans', sans-serif;
    }

    /* ══════════════════════════════════════════════════
       ANIMATIONS GLOBALES
    ══════════════════════════════════════════════════ */
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(32px) }
        to   { opacity: 1; transform: translateY(0) }
    }
    @keyframes fade-down {
        from { opacity: 0; transform: translateY(-20px) }
        to   { opacity: 1; transform: translateY(0) }
    }
    @keyframes fade-left {
        from { opacity: 0; transform: translateX(40px) }
        to   { opacity: 1; transform: translateX(0) }
    }
    @keyframes fade-right {
        from { opacity: 0; transform: translateX(-40px) }
        to   { opacity: 1; transform: translateX(0) }
    }
    @keyframes scale-in {
        from { opacity: 0; transform: scale(.92) }
        to   { opacity: 1; transform: scale(1) }
    }
    @keyframes float {
        0%,100% { transform: translateY(0)  }
        50%     { transform: translateY(-8px) }
    }
    @keyframes road {
        from { background-position: 0 0 }
        to   { background-position: 0 200px }
    }
    @keyframes shimmer-line {
        0%   { left: -100% }
        100% { left: 200%  }
    }
    @keyframes cd-blink {
        0%,100% { opacity: 1 }
        50%     { opacity: 0 }
    }
    @keyframes pulse-ring {
        0%   { box-shadow: 0 0 0 0   rgba(175,38,54,.4); }
        70%  { box-shadow: 0 0 0 14px rgba(175,38,54,0); }
        100% { box-shadow: 0 0 0 0   rgba(175,38,54,0); }
    }

    /* ── Reveal système amélioré ── */
    .reveal {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity .7s cubic-bezier(.4,0,.2,1),
                    transform .7s cubic-bezier(.4,0,.2,1);
    }
    .reveal.from-left  { transform: translateX(-40px); }
    .reveal.from-right { transform: translateX(40px); }
    .reveal.from-scale { transform: scale(.94); }
    .reveal.visible    { opacity: 1; transform: none !important; }

    /* Stagger enfants */
    .stagger-children > * {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity .55s ease, transform .55s ease;
    }
    .stagger-children.visible > *:nth-child(1) { transition-delay:.05s; opacity:1; transform:none }
    .stagger-children.visible > *:nth-child(2) { transition-delay:.15s; opacity:1; transform:none }
    .stagger-children.visible > *:nth-child(3) { transition-delay:.25s; opacity:1; transform:none }
    .stagger-children.visible > *:nth-child(4) { transition-delay:.35s; opacity:1; transform:none }
    .stagger-children.visible > *:nth-child(5) { transition-delay:.45s; opacity:1; transform:none }
    .stagger-children.visible > *:nth-child(6) { transition-delay:.55s; opacity:1; transform:none }

    .counter-num { display: inline-block; }

    /* ══════════════════════════════════════════════════
       SÉPARATEURS VAGUE
    ══════════════════════════════════════════════════ */
    .wave-sep {
        width: 100%;
        overflow: hidden;
        line-height: 0;
        margin-bottom: -2px;
    }
    .wave-sep svg { display: block; width: 100%; }

    /* ══════════════════════════════════════════════════
       UTILITAIRES
    ══════════════════════════════════════════════════ */
    .section-tag {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--rouge);
        margin-bottom: .5rem;
        display: inline-flex;
        align-items: center;
        gap: .35rem;
    }
    .section-title {
        font-family: var(--font-d) !important;
        font-size: clamp(1.7rem, 3.5vw, 2.2rem);
        font-weight: 800;
        color: var(--texte);
        margin-bottom: 1rem;
    }
    .section-sub {
        color: var(--texte-2);
        max-width: 520px;
        margin: 0 auto;
        font-size: 1rem;
        line-height: 1.65;
    }

    /* ══════════════════════════════════════════════════
       BOUTONS
    ══════════════════════════════════════════════════ */
    .btn-hero-primary {
        background: #fff;
        color: var(--rouge);
        font-family: var(--font-d) !important;
        font-weight: 800;
        font-size: 1rem;
        padding: .88rem 2rem;
        border-radius: 12px;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        transition: transform .25s ease, box-shadow .25s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,.18);
    }
    .btn-hero-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,.28);
        color: var(--rouge);
    }
    .btn-hero-outline {
        border: 2px solid rgba(255,255,255,.4);
        color: #fff;
        font-weight: 600;
        font-size: .95rem;
        padding: .85rem 1.75rem;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        transition: .25s ease;
    }
    .btn-hero-outline:hover {
        border-color: rgba(255,255,255,.9);
        color: #fff;
        background: rgba(255,255,255,.12);
    }
    .btn-cta-main {
        background: linear-gradient(135deg, var(--rouge), var(--rouge-c));
        color: #fff;
        font-family: var(--font-d) !important;
        font-weight: 800;
        font-size: 1rem;
        padding: .88rem 2.25rem;
        border-radius: 12px;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        transition: .25s ease;
        box-shadow: 0 4px 20px rgba(175,38,54,.35);
        cursor: pointer;
    }
    .btn-cta-main:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 32px rgba(175,38,54,.5);
        color: #fff;
    }
    .btn-cta-vert {
        background: linear-gradient(135deg, var(--vert), var(--vert-c));
        color: #fff;
        font-family: var(--font-d) !important;
        font-weight: 800;
        font-size: 1rem;
        padding: .88rem 2.25rem;
        border-radius: 12px;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        transition: .25s ease;
        box-shadow: 0 4px 20px rgba(45,106,79,.35);
        cursor: pointer;
    }
    .btn-cta-vert:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 32px rgba(45,106,79,.5);
        color: #fff;
    }

    /* ══════════════════════════════════════════════════
       HERO
    ══════════════════════════════════════════════════ */
    .hero {
        background: linear-gradient(135deg, var(--rouge-c) 0%, var(--rouge) 55%, #6B1520 100%);
        min-height: 92vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: repeating-linear-gradient(90deg,
            transparent 49.5%, rgba(255,255,255,.05) 49.7%,
            rgba(255,255,255,.05) 50.3%, transparent 50.5%);
        animation: road 10s linear infinite;
    }
    .hero-circle   { position:absolute; right:-180px; top:-120px; width:600px; height:600px; border-radius:50%; background:rgba(45,106,79,.08); border:1px solid rgba(45,106,79,.15); animation:float 8s ease-in-out infinite; }
    .hero-circle-2 { position:absolute; left:-100px; bottom:-80px; width:350px; height:350px; border-radius:50%; background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.07); animation:float 10s ease-in-out infinite reverse; }
    .hero-content  { position:relative; z-index:1; }
    .hero-eyebrow  { display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);color:#fff;font-size:.82rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.4rem .9rem;border-radius:50px;margin-bottom:1.5rem;animation:fade-up .6s .1s both; }
    .hero-title    { font-family:var(--font-d) !important;font-weight:800;font-size:clamp(2.2rem,5vw,3.5rem);color:#fff;line-height:1.12;margin-bottom:1.25rem;animation:fade-up .6s .2s both; }
    .hero-title span { color:rgba(255,255,255,.85);text-decoration:underline;text-decoration-color:var(--or);text-underline-offset:6px; }
    .hero-desc     { color:rgba(255,255,255,.82);font-size:1.05rem;max-width:520px;line-height:1.72;margin-bottom:2rem;animation:fade-up .6s .3s both; }
    .hero-cta      { display:flex;flex-wrap:wrap;gap:1rem;animation:fade-up .6s .4s both; }
    .stat-bubble   { position:absolute;background:#fff;border-radius:14px;padding:.75rem 1rem;box-shadow:0 8px 30px rgba(0,0,0,.2);font-family:var(--font-d) !important;border-left:3px solid var(--rouge); }
    .stat-bubble .num { font-size:1.4rem;font-weight:800;color:var(--texte); }
    .stat-bubble .lbl { font-size:.72rem;color:var(--texte-2); }

    /* Shimmer sur stat-bubble */
    .stat-bubble::after {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 60%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.35), transparent);
        animation: shimmer-line 2.5s ease-in-out infinite;
    }

    /* ══════════════════════════════════════════════════
       COMPTEUR FLOTTANT
    ══════════════════════════════════════════════════ */
    .views-float {
        position: fixed;
        bottom: 100px;
        left: 24px;
        z-index: 9990;
        background: var(--rouge-c);
        border: 1.5px solid rgba(255,255,255,.18);
        border-radius: 50px;
        padding: .5rem 1rem .5rem .6rem;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        box-shadow: 0 4px 20px rgba(175,38,54,.4);
        animation: float 4s ease-in-out infinite;
        cursor: default;
        transition: transform .25s ease;
    }
    .views-float:hover { transform: translateY(-4px) scale(1.04); animation-play-state: paused; }
    .views-float .vf-icon  { width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,.15);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0; }
    .views-float .vf-count { font-family:var(--font-d) !important;font-weight:900;color:#fff;font-size:1rem;min-width:42px; }
    .views-float .vf-label { font-size:.7rem;color:rgba(255,255,255,.7);line-height:1.2;white-space:nowrap; }
    @media(max-width:575px) {
        .views-float { bottom:82px;left:14px; }
        .views-float .vf-label { display:none; }
    }

    /* ══════════════════════════════════════════════════
       ANNONCE + COUNTDOWN
    ══════════════════════════════════════════════════ */
    .announce-section {
        background: linear-gradient(135deg, var(--rouge-c) 0%, var(--rouge) 60%, #6B1520 100%);
        padding: 2.75rem 0;
        position: relative;
        overflow: hidden;
    }
    .announce-section::before {
        content:'';position:absolute;inset:0;
        background:repeating-linear-gradient(-45deg,transparent,transparent 18px,rgba(255,255,255,.03) 18px,rgba(255,255,255,.03) 36px);
        pointer-events:none;
    }
    .announce-inner        { position:relative;z-index:1;display:flex;flex-wrap:wrap;align-items:center;gap:2rem;justify-content:space-between; }
    .announce-text-col     { flex:1;min-width:260px; }
    .announce-emoji-badge  { display:inline-flex;align-items:center;gap:.45rem;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);border-radius:50px;padding:.35rem .9rem;font-size:.78rem;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:.08em;margin-bottom:.85rem; }
    .announce-title        { font-family:var(--font-d) !important;font-size:clamp(1.15rem,2.5vw,1.5rem);font-weight:800;color:#fff;line-height:1.3;margin-bottom:.5rem; }
    .announce-subtitle     { font-size:.88rem;color:rgba(255,255,255,.78);line-height:1.6; }
    .announce-cta          { display:inline-flex;align-items:center;gap:.5rem;background:#fff;color:var(--rouge);font-family:var(--font-d) !important;font-weight:800;font-size:.88rem;padding:.65rem 1.5rem;border-radius:10px;text-decoration:none;margin-top:1rem;transition:.25s ease;box-shadow:0 4px 16px rgba(0,0,0,.2); }
    .announce-cta:hover    { transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.3);color:var(--rouge); }
    .countdown-col         { flex-shrink:0; }
    .countdown-grid        { display:flex;gap:.65rem;align-items:center; }
    .cd-block              { background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.2);border-radius:14px;padding:.75rem .85rem;text-align:center;min-width:68px;backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);transition:background .3s; }
    .cd-block.pulse        { background:rgba(255,255,255,.25); }
    .cd-val                { font-family:var(--font-d) !important;font-size:2rem;font-weight:900;color:#fff;line-height:1;display:block;font-variant-numeric:tabular-nums;min-width:2.2ch; }
    .cd-lbl                { font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.65);margin-top:.3rem;display:block; }
    .cd-sep                { font-size:1.8rem;font-weight:900;color:rgba(255,255,255,.4);line-height:1;padding-bottom:.4rem;animation:cd-blink 1s step-end infinite; }
    @media(max-width:640px) {
        .announce-inner  { flex-direction:column;align-items:flex-start;gap:1.5rem; }
        .countdown-col   { width:100%; }
        .countdown-grid  { justify-content:center; }
        .cd-val          { font-size:1.6rem; }
        .cd-block        { min-width:56px;padding:.6rem .65rem; }
    }

    /* ══════════════════════════════════════════════════
       BANDE CONFIANCE
    ══════════════════════════════════════════════════ */
    .trust-band {
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 1.1rem 0;
        overflow: hidden;
    }
    .trust-item   { display:inline-flex;align-items:center;gap:.55rem;font-size:.82rem;font-weight:600;color:var(--texte-2);padding:.25rem .75rem;white-space:nowrap;transition:color .2s; }
    .trust-item:hover { color: var(--texte); }
    .trust-item i { font-size:1.1rem; }
    .trust-divider { color:var(--border);font-size:1.2rem; }

    /* ══════════════════════════════════════════════════
       STATS BAR
    ══════════════════════════════════════════════════ */
    .stats-bar { background:var(--fond);border-bottom:1px solid var(--border);padding:1.5rem 0; }
    .stat-item  { text-align:center;padding:.5rem 1rem; }
    .stat-item .number { font-family:var(--font-d) !important;font-size:2rem;font-weight:800;color:var(--rouge);display:block; }
    .stat-item .label  { font-size:.82rem;color:var(--texte-2);font-weight:500;display:block;margin-top:.1rem; }
    .stat-item + .stat-item { border-left:1px solid var(--border); }

    /* ══════════════════════════════════════════════════
       COMMENT ÇA MARCHE
    ══════════════════════════════════════════════════ */
    .steps-section { padding:5.5rem 0;background:#fff;position:relative; }
    .step-card     { text-align:center;padding:2rem 1.25rem;position:relative; }

    /* Ligne de connexion animée entre étapes */
    .step-connector {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 .5rem;
        padding-top: 1.5rem;
        color: var(--border);
        font-size: 1.8rem;
    }
    .step-connector i {
        animation: float 2s ease-in-out infinite;
    }

    .step-num {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        color: #fff;
        font-family: var(--font-d) !important;
        font-weight: 900;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        box-shadow: 0 8px 24px rgba(175,38,54,.3);
        transition: transform .3s ease, box-shadow .3s ease;
        animation: pulse-ring 3s ease-in-out infinite;
    }
    .step-num:hover { transform: scale(1.1); box-shadow: 0 12px 32px rgba(175,38,54,.45); }
    .step-card:hover .step-num { transform: scale(1.08) rotate(3deg); }
    .step-title { font-family:var(--font-d) !important;font-weight:800;font-size:1rem;color:var(--texte);margin-bottom:.5rem; }
    .step-desc  { font-size:.86rem;color:var(--texte-2);line-height:1.65; }
    .step-badge { display:inline-block;background:var(--rouge-p);color:var(--rouge);font-size:.72rem;font-weight:700;padding:.25rem .75rem;border-radius:50px;margin-top:.6rem; }

    /* ══════════════════════════════════════════════════
       FEATURES
    ══════════════════════════════════════════════════ */
    .features    { padding:5rem 0;background:var(--bg); }
    .feature-card {
        background: #fff;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        height: 100%;
        border: 1.5px solid var(--border);
        transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
        position: relative;
        overflow: hidden;
    }
    .feature-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--rouge), var(--or));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .35s ease;
    }
    .feature-card:hover {
        transform: translateY(-7px);
        border-color: transparent;
        box-shadow: 0 16px 44px rgba(175,38,54,.12);
    }
    .feature-card:hover::before { transform: scaleX(1); }
    .feature-icon  { width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;font-size:1.5rem;transition:transform .3s ease; }
    .feature-card:hover .feature-icon { transform: rotate(-5deg) scale(1.1); }
    .feature-title { font-family:var(--font-d) !important;font-size:1.05rem;font-weight:700;color:var(--texte);margin-bottom:.5rem; }
    .feature-desc  { font-size:.88rem;color:var(--texte-2);line-height:1.65; }

    /* ══════════════════════════════════════════════════
       TARIFS
    ══════════════════════════════════════════════════ */
    .pricing-section { padding:5.5rem 0;background:#fff; }
    .pricing-card {
        background: #fff;
        border-radius: 24px;
        border: 2.5px solid var(--rouge);
        padding: 2.5rem 2rem 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(175,38,54,.15);
        max-width: 580px;
        margin: 0 auto;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .pricing-card:hover { transform: translateY(-5px); box-shadow: 0 28px 72px rgba(175,38,54,.22); }
    .pricing-card::before { content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--rouge),var(--or),var(--vert)); }
    .pricing-badge { position:absolute;top:1.25rem;right:1.25rem;background:linear-gradient(135deg,var(--or),var(--or-c));color:var(--texte);font-size:.72rem;font-weight:900;padding:.3rem .85rem;border-radius:50px;font-family:var(--font-d) !important;letter-spacing:.05em;box-shadow:0 3px 10px rgba(197,160,89,.4); }
    .category-selector { display:flex;flex-wrap:wrap;gap:.65rem;margin-bottom:2rem;justify-content:center; }
    .category-btn { flex:1;min-width:90px;padding:.7rem 1rem;border-radius:12px;border:2px solid var(--border);background:#fff;color:var(--texte-2);font-weight:700;font-size:.82rem;text-align:center;cursor:pointer;transition:all .25s ease;font-family:var(--font-d) !important; }
    .category-btn:hover { border-color:var(--rouge);color:var(--rouge);transform:translateY(-2px); }
    .category-btn.active { background:linear-gradient(135deg,var(--rouge),var(--rouge-c));border-color:var(--rouge);color:#fff;box-shadow:0 4px 14px rgba(175,38,54,.3); }
    .pricing-name  { font-family:var(--font-d) !important;font-size:1.2rem;font-weight:800;color:var(--texte);margin-bottom:.75rem;min-height:1.5rem; }
    .pricing-description { font-size:.86rem;color:var(--texte-2);margin-bottom:1.5rem;line-height:1.65;min-height:2.5rem; }
    .pricing-price-container { margin-bottom:1.75rem; }
    .pricing-original-price  { font-size:1.1rem;color:var(--texte-2);text-decoration:line-through;font-weight:600;margin-bottom:.35rem; }
    .pricing-discount-badge  { display:inline-block;background:var(--vert-p);color:var(--vert);font-size:.75rem;font-weight:700;padding:.35rem .85rem;border-radius:50px;font-family:var(--font-d) !important;margin-bottom:.5rem; }
    .pricing-price-row { display:flex;align-items:end;gap:.5rem;margin-bottom:.5rem; }
    .pricing-price { font-family:var(--font-d) !important;font-size:3.2rem;font-weight:900;color:var(--vert);line-height:1; }
    .pricing-price sup { font-size:1.1rem;vertical-align:super;margin-right:.2rem; }
    .pricing-currency { font-size:1rem;color:var(--texte-2);font-weight:600;margin-bottom:.5rem; }
    .pricing-list { list-style:none;padding:0;margin:0 0 2rem; }
    .pricing-list li { display:flex;align-items:flex-start;gap:.75rem;padding:.6rem 0;border-bottom:1px solid var(--border);font-size:.9rem;color:var(--texte); }
    .pricing-list li:last-child { border-bottom:none; }
    .pricing-list .pi { width:22px;height:22px;border-radius:50%;background:var(--vert-p);color:var(--vert);display:flex;align-items:center;justify-content:center;font-size:.75rem;flex-shrink:0;margin-top:.1rem; }
    .pricing-note { background:var(--or-p);border-left:3px solid var(--or);padding:.75rem 1rem;border-radius:8px;font-size:.78rem;color:var(--texte-2);line-height:1.65;margin-top:1.25rem; }
    .pricing-note strong { color:var(--texte);font-weight:700; }
    .pricing-guarantee { display:flex;align-items:center;gap:.5rem;font-size:.8rem;color:var(--texte-2);margin-top:1rem;justify-content:center; }

    /* ══════════════════════════════════════════════════
       QUI SOMMES-NOUS
    ══════════════════════════════════════════════════ */
    .about-section {
        padding: 5.5rem 0;
        background: var(--bg);
        position: relative;
        overflow: hidden;
    }
    .about-section::before { content:'';position:absolute;top:-120px;right:-120px;width:420px;height:420px;border-radius:50%;background:var(--rouge-p);opacity:.35;pointer-events:none; }
    .about-section::after  { content:'';position:absolute;bottom:-80px;left:-80px;width:280px;height:280px;border-radius:50%;background:var(--vert-p);opacity:.4;pointer-events:none; }

    .director-card {
        background: linear-gradient(135deg, var(--rouge-c), var(--rouge));
        border-radius: 20px;
        padding: 2rem 1.75rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 48px rgba(175,38,54,.3);
        height: 100%;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .director-card:hover { transform: translateY(-4px); box-shadow: 0 24px 60px rgba(175,38,54,.4); }
    .director-card::before { content:'';position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.06);pointer-events:none; }
    .director-avatar  { width:75px;height:75px;border-radius:50%;background:rgba(255,255,255,.18);border:3px solid rgba(255,255,255,.35);display:flex;align-items:center;justify-content:center;font-family:var(--font-d) !important;font-weight:900;font-size:1.6rem;color:#fff;flex-shrink:0;margin-bottom:1.1rem; }
    .director-name    { font-family:var(--font-d) !important;font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:.2rem; }
    .director-title   { font-size:.8rem;color:rgba(255,255,255,.7);font-weight:500;text-transform:uppercase;letter-spacing:.08em;margin-bottom:1.25rem; }
    .director-quote   { font-size:.9rem;color:rgba(255,255,255,.88);line-height:1.7;font-style:italic;border-left:3px solid rgba(255,255,255,.3);padding-left:.85rem;margin-bottom:1.25rem; }
    .director-location { display:inline-flex;align-items:center;gap:.45rem;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:50px;padding:.4rem .9rem;font-size:.78rem;color:rgba(255,255,255,.9);font-weight:600; }

    .about-intro   { font-size:1rem;color:var(--texte-2);line-height:1.8;margin-bottom:1.5rem; }
    .about-intro strong { color:var(--texte);font-weight:700; }
    .about-mission { background:#fff;border-left:4px solid var(--vert);border-radius:0 12px 12px 0;padding:1.1rem 1.25rem;font-size:.9rem;color:var(--texte-2);line-height:1.72;margin-bottom:1.75rem; }
    .about-mission strong { color:var(--vert-c);font-weight:700; }

    .offer-card { background:#fff;border-radius:16px;border:1.5px solid var(--border);padding:1.5rem 1.25rem;height:100%;transition:.28s ease;position:relative;overflow:hidden; }
    .offer-card::before { content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:3px 3px 0 0;opacity:0;transition:opacity .28s ease; }
    .offer-card:hover { transform:translateY(-5px);box-shadow:0 12px 36px rgba(0,0,0,.09);border-color:transparent; }
    .offer-card:hover::before { opacity:1; }
    .offer-card.rouge::before { background:linear-gradient(90deg,var(--rouge),var(--rouge-c)); }
    .offer-card.vert::before  { background:linear-gradient(90deg,var(--vert),var(--vert-c)); }
    .offer-card.or::before    { background:linear-gradient(90deg,var(--or),var(--or-c)); }
    .offer-icon  { width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1.1rem;flex-shrink:0;transition:transform .3s ease; }
    .offer-card:hover .offer-icon { transform: scale(1.12) rotate(-4deg); }
    .offer-title { font-family:var(--font-d) !important;font-size:.98rem;font-weight:800;color:var(--texte);margin-bottom:.5rem; }
    .offer-desc  { font-size:.85rem;color:var(--texte-2);line-height:1.65;margin:0; }
    .permit-badges { display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.75rem; }
    .permit-badge  { display:inline-flex;align-items:center;gap:.3rem;background:var(--rouge-p);color:var(--rouge-c);font-family:var(--font-d) !important;font-weight:800;font-size:.75rem;padding:.25rem .65rem;border-radius:6px;border:1px solid rgba(175,38,54,.15); }

    /* ══════════════════════════════════════════════════
       APERÇU PLATEFORME
    ══════════════════════════════════════════════════ */
    .preview-section { padding:5.5rem 0;background:#fff; }
    .preview-tabs    { display:flex;gap:.5rem;flex-wrap:wrap;justify-content:center;margin-bottom:2rem; }
    .preview-tab {
        padding:.5rem 1.25rem;border-radius:50px;font-size:.85rem;font-weight:700;
        border:2px solid var(--border);background:#fff;color:var(--texte-2);
        cursor:pointer;transition:.2s ease;
    }
    .preview-tab:hover  { border-color:var(--rouge);color:var(--rouge);transform:translateY(-1px); }
    .preview-tab.active { background:var(--rouge);border-color:var(--rouge);color:#fff;box-shadow:0 4px 14px rgba(175,38,54,.3); }
    .preview-frame { background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.12);border:1px solid var(--border);display:none; }
    .preview-frame.active { display:block;animation:scale-in .4s cubic-bezier(.4,0,.2,1) both; }
    .preview-topbar { background:var(--rouge-c);padding:.6rem 1.25rem;display:flex;align-items:center;gap:.5rem; }
    .preview-dot    { width:10px;height:10px;border-radius:50%; }
    .preview-body   { padding:1.5rem;background:#fff; }
    .mock-q-progress { height:6px;background:var(--border);border-radius:3px;margin-bottom:1rem;overflow:hidden; }
    .mock-q-bar      { height:100%;width:45%;background:linear-gradient(90deg,var(--rouge),var(--or));border-radius:3px; }
    .mock-q-text     { font-family:var(--font-d) !important;font-weight:700;font-size:1rem;color:var(--texte);margin-bottom:1rem; }
    .mock-option     { padding:.65rem 1rem;border-radius:10px;border:1.5px solid var(--border);margin-bottom:.5rem;font-size:.88rem;color:var(--texte-2);cursor:default;transition:.2s; }
    .mock-option.correct { background:var(--vert-p);border-color:var(--vert);color:var(--vert-c);font-weight:700; }
    .mock-kpi-row { display:flex;gap:.75rem;margin-bottom:1rem; }
    .mock-kpi     { flex:1;background:var(--bg);border-radius:10px;padding:.75rem;text-align:center;border:1.5px solid var(--border); }
    .mock-kpi .mk-val { font-family:var(--font-d) !important;font-size:1.3rem;font-weight:900;color:var(--rouge); }
    .mock-kpi .mk-lbl { font-size:.7rem;color:var(--texte-2); }
    .mock-prog-bar  { height:8px;background:var(--border);border-radius:4px;overflow:hidden;margin-top:.3rem; }
    .mock-prog-fill { height:100%;border-radius:4px; }
    .mock-doc-row   { display:flex;align-items:center;gap:.75rem;padding:.65rem;border-radius:10px;border:1.5px solid var(--border);margin-bottom:.5rem; }
    .mock-doc-icon  { width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0; }
    .mock-badge     { font-size:.68rem;font-weight:700;padding:.2rem .6rem;border-radius:50px;margin-left:auto; }

    /* ══════════════════════════════════════════════════
       GALERIE
    ══════════════════════════════════════════════════ */
    .gallery-section { padding:5.5rem 0;background:var(--bg); }
    .gallery-filters { display:flex;flex-wrap:wrap;gap:.5rem;justify-content:center;margin-bottom:2.5rem; }
    .gf-btn {
        padding:.5rem 1.35rem;border-radius:50px;font-size:.85rem;font-weight:700;
        border:2px solid var(--border);background:#fff;color:var(--texte-2);
        cursor:pointer;transition:all .22s ease;font-family:var(--font-d) !important;letter-spacing:.02em;
    }
    .gf-btn:hover  { border-color:var(--rouge);color:var(--rouge);transform:translateY(-2px); }
    .gf-btn.active { background:linear-gradient(135deg,var(--rouge),var(--rouge-c));border-color:var(--rouge);color:#fff;box-shadow:0 4px 14px rgba(175,38,54,.3); }
    .gallery-grid  { display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.1rem; }
    .gallery-item  {
        border-radius:16px;overflow:hidden;position:relative;aspect-ratio:4/3;cursor:pointer;background:var(--border);
        opacity:0;transform:scale(.96) translateY(12px);
        transition:opacity .45s cubic-bezier(.4,0,.2,1), transform .45s cubic-bezier(.4,0,.2,1);
    }
    .gallery-item.visible { opacity:1;transform:scale(1) translateY(0); }
    .gallery-item.hidden  { display:none; }
    .gallery-item img     { width:100%;height:100%;object-fit:cover;display:block;transition:transform .45s ease; }
    .gallery-item:hover img { transform:scale(1.08); }
    .gallery-overlay {
        position:absolute;inset:0;
        background:linear-gradient(to top,rgba(139,30,43,.85) 0%,transparent 60%);
        opacity:0;transition:opacity .3s ease;display:flex;align-items:flex-end;padding:1rem;
    }
    .gallery-item:hover .gallery-overlay { opacity:1; }
    .gallery-overlay-title { color:#fff;font-family:var(--font-d) !important;font-weight:700;font-size:.88rem;line-height:1.3; }
    .gallery-overlay-cat   { font-size:.72rem;color:rgba(255,255,255,.75);margin-top:.2rem; }
    .lightbox-bg    { position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:10000;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s ease;padding:1rem; }
    .lightbox-bg.open { opacity:1;pointer-events:all; }
    .lightbox-img   { max-width:min(90vw,900px);max-height:80vh;border-radius:16px;object-fit:contain;box-shadow:0 24px 80px rgba(0,0,0,.6);transform:scale(.9);transition:transform .3s cubic-bezier(.4,0,.2,1); }
    .lightbox-bg.open .lightbox-img { transform:scale(1); }
    .lightbox-close { position:absolute;top:1.25rem;right:1.5rem;width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,.12);border:none;color:#fff;font-size:1.2rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s; }
    .lightbox-close:hover { background:rgba(255,255,255,.22); }
    .lightbox-caption { position:absolute;bottom:1.5rem;left:50%;transform:translateX(-50%);color:rgba(255,255,255,.85);font-size:.85rem;font-weight:600;background:rgba(0,0,0,.4);padding:.4rem 1rem;border-radius:50px;white-space:nowrap; }
    .gallery-empty  { grid-column:1/-1;text-align:center;padding:3rem;color:var(--texte-2);font-size:.9rem; }

    /* ══════════════════════════════════════════════════
       TÉMOIGNAGES
    ══════════════════════════════════════════════════ */
    .testi-section { padding:5rem 0;background:#fff; }
    .testi-card {
        background: var(--fond);
        border-radius: 18px;
        padding: 1.75rem;
        border: 1.5px solid var(--border);
        transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
        height: 100%;
        position: relative;
    }
    .testi-card::before { content:'"';position:absolute;top:.5rem;left:1.25rem;font-size:4rem;color:var(--rouge-p);font-family:Georgia,serif;line-height:1; }
    .testi-card:hover   { transform:translateY(-5px);box-shadow:0 12px 32px rgba(175,38,54,.12);border-color:var(--rouge-p); }
    .testi-stars { color:var(--or);font-size:.9rem;margin-bottom:.75rem; }

    /* ══════════════════════════════════════════════════
       FAQ
    ══════════════════════════════════════════════════ */
    .faq-section { padding:5.5rem 0;background:var(--bg); }
    .faq-item    { background:#fff;border-radius:14px;border:1.5px solid var(--border);margin-bottom:.6rem;overflow:hidden;transition:border-color .2s,box-shadow .2s; }
    .faq-item:hover { box-shadow:0 4px 16px rgba(175,38,54,.07); }
    .faq-item.open  { border-color:var(--rouge);box-shadow:0 4px 20px rgba(175,38,54,.12); }
    .faq-question   { display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.4rem;cursor:pointer;font-weight:700;font-size:.93rem;color:var(--texte);gap:1rem;user-select:none;transition:color .2s; }
    .faq-question:hover { color:var(--rouge); }
    .faq-icon       { width:28px;height:28px;border-radius:50%;background:var(--rouge-p);color:var(--rouge);display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0;transition:transform .3s ease,background .3s,color .3s; }
    .faq-item.open .faq-icon { transform:rotate(45deg);background:var(--rouge);color:#fff; }
    .faq-answer     { max-height:0;overflow:hidden;transition:max-height .38s cubic-bezier(.4,0,.2,1),padding .38s ease;font-size:.88rem;color:var(--texte-2);line-height:1.7;padding:0 1.4rem; }
    .faq-answer.open { max-height:320px;padding:.25rem 1.4rem 1.1rem; }

    /* ══════════════════════════════════════════════════
       INFOS PRATIQUES
    ══════════════════════════════════════════════════ */
    .info-section    { padding:5.5rem 0;background:#fff; }
    .info-card       { background:#fff;border-radius:20px;border:1.5px solid var(--border);overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.06);height:100%;transition:.3s ease; }
    .info-card:hover { box-shadow:0 12px 40px rgba(175,38,54,.12);transform:translateY(-3px); }
    .info-card-header { display:flex;align-items:center;gap:1rem;padding:1.3rem 1.5rem;border-bottom:1px solid var(--border); }
    .info-card-icon   { width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;flex-shrink:0; }
    .info-card-title  { font-family:var(--font-d) !important;font-size:1.05rem;font-weight:800;color:var(--texte);margin:0; }
    .info-card-body   { padding:1.25rem 1.5rem; }
    .contact-row      { display:flex;align-items:flex-start;gap:.85rem;padding:.85rem;background:var(--bg);border-radius:12px;margin-bottom:.6rem;text-decoration:none;transition:background .2s,transform .2s; }
    .contact-row:last-child { margin-bottom:0; }
    .contact-row:hover { background:var(--rouge-p);transform:translateX(4px); }
    .contact-row-icon { width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:.88rem;flex-shrink:0;color:#fff; }
    .contact-row-text { color:var(--texte);font-weight:600;font-size:.87rem;line-height:1.55; }
    .hours-row        { display:flex;justify-content:space-between;align-items:center;padding:.72rem 1rem;border-radius:9px;margin-bottom:.4rem;background:var(--bg);font-size:.84rem;transition:.2s; }
    .hours-row:hover  { background:var(--rouge-p); }
    .hours-row.today  { background:var(--vert-p);border:1px solid var(--vert); }
    .hours-row.ferme .hours-time { color:#9CA3AF; }
    .hours-day        { font-weight:600;color:var(--texte);display:flex;align-items:center;gap:.4rem; }
    .hours-time       { color:var(--texte-2);font-weight:500; }
    .hours-row.today .hours-day { color:var(--vert-c); }
    .hours-row.today .hours-time { color:var(--vert);font-weight:600; }
    .map-card         { background:#fff;border-radius:20px;border:1.5px solid var(--border);overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.06); }
    .map-card-header  { display:flex;align-items:center;gap:1rem;padding:1.3rem 1.5rem;border-bottom:1px solid var(--border); }
    .map-gps-btns     { display:flex;gap:.75rem;flex-wrap:wrap;padding:1.25rem 1.5rem; }
    .map-btn          { flex:1;min-width:130px;display:inline-flex;align-items:center;justify-content:center;gap:.55rem;padding:.7rem 1.2rem;border-radius:12px;font-weight:700;font-size:.85rem;text-decoration:none;transition:.25s ease; }
    .map-btn:hover    { transform:translateY(-2px); }
    .map-btn-google   { background:#4285F4;color:#fff;box-shadow:0 4px 12px rgba(66,133,244,.3); }
    .map-btn-google:hover { color:#fff;box-shadow:0 6px 20px rgba(66,133,244,.45); }
    .map-btn-waze     { background:#09C;color:#fff;box-shadow:0 4px 12px rgba(0,153,204,.3); }
    .map-btn-waze:hover { color:#fff;box-shadow:0 6px 20px rgba(0,153,204,.45); }

    /* ══════════════════════════════════════════════════
       CTA FINAL
    ══════════════════════════════════════════════════ */
    .cta-section {
        background: linear-gradient(135deg, var(--rouge-c) 0%, var(--rouge) 50%, var(--vert-c) 100%);
        padding: 5.5rem 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .cta-section::before { content:'';position:absolute;inset:0;background:repeating-linear-gradient(-45deg,transparent,transparent 20px,rgba(255,255,255,.03) 20px,rgba(255,255,255,.03) 40px); }

</style>
@endsection

@section('content')

{{-- ═══ COMPTEUR FLOTTANT ═══ --}}
<div class="views-float" title="Visiteurs">
    <div class="vf-icon"><i class="bi bi-eye-fill"></i></div>
    <div class="vf-count" id="viewCount" data-target="{{ $totalVues }}">0</div>
    <div class="vf-label">visiteurs<br>sur ce site</div>
</div>

{{-- ═══════════════════════════════════════════════════
     1. HERO
     Objectif : Accrocher, expliquer la valeur en 3 secondes
═══════════════════════════════════════════════════ --}}
<section class="hero" aria-label="Présentation">
    <div class="hero-circle"></div>
    <div class="hero-circle-2"></div>
    <div class="container hero-content py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-eyebrow">
                    <i class="bi bi-geo-alt-fill"></i> Abidjan — Abobo Dokui
                </div>
                <h1 class="hero-title">
                    Obtenez votre permis<br>avec <span>Le Chemin</span>
                </h1>
                <p class="hero-desc">
                    Formation complète en ligne — cours théoriques, quiz interactifs et
                    accompagnement personnalisé. Votre réussite est notre engagement.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('register') }}" class="btn-hero-primary">
                        <i class="bi bi-rocket-takeoff-fill" style="color:var(--vert);"></i>
                        Commencez maintenant
                    </a>
                    <a href="#comment-ca-marche" class="btn-hero-outline">
                        <i class="bi bi-play-circle"></i>Voir comment ça marche
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div style="position:relative;z-index:1;animation:fade-left .7s .2s both;">
                    <svg viewBox="0 0 480 380" xmlns="http://www.w3.org/2000/svg" style="max-width:480px;width:100%;">
                        <ellipse cx="240" cy="340" rx="220" ry="30" fill="rgba(0,0,0,.2)" />
                        <rect x="60" y="260" width="360" height="80" rx="12" fill="#0D1B2A" />
                        <rect x="110" y="294" width="50" height="8" rx="4" fill="#fff" opacity=".5" />
                        <rect x="215" y="294" width="50" height="8" rx="4" fill="#fff" opacity=".5" />
                        <rect x="320" y="294" width="50" height="8" rx="4" fill="#fff" opacity=".5" />
                        <rect x="140" y="210" width="200" height="70" rx="14" fill="#AF2636" />
                        <rect x="165" y="185" width="150" height="45" rx="12" fill="#8A1E2B" />
                        <rect x="175" y="192" width="60" height="30" rx="6" fill="rgba(180,220,255,.75)" />
                        <rect x="245" y="192" width="60" height="30" rx="6" fill="rgba(180,220,255,.75)" />
                        <circle cx="180" cy="284" r="28" fill="#1A1A2E" />
                        <circle cx="180" cy="284" r="16" fill="#2D2D4E" />
                        <circle cx="180" cy="284" r="6"  fill="#C5A059" />
                        <circle cx="300" cy="284" r="28" fill="#1A1A2E" />
                        <circle cx="300" cy="284" r="16" fill="#2D2D4E" />
                        <circle cx="300" cy="284" r="6"  fill="#C5A059" />
                        <ellipse cx="342" cy="230" rx="12" ry="8" fill="#FFC107" opacity=".9" />
                        <ellipse cx="138" cy="230" rx="12" ry="8" fill="#FF7676" opacity=".8" />
                        <rect x="390" y="140" width="4" height="130" fill="#6B7280" />
                        <circle cx="392" cy="120" r="30" fill="#2D6A4F" />
                        <rect x="376" y="112" width="32" height="14" rx="3" fill="#fff" />
                    </svg>
                    <div class="stat-bubble" style="top:18%;left:-5px;animation:fade-up .6s .4s both;">
                        <div class="num">98%</div>
                        <div class="lbl">Taux de réussite</div>
                    </div>
                    <div class="stat-bubble" style="bottom:28%;right:-12px;animation:fade-up .6s .55s both;border-left-color:var(--vert);">
                        <div class="num" style="color:var(--vert);">1000+</div>
                        <div class="lbl">candidats qui ont déjà obtenus leurs permis chez nous.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     2. ANNONCE + COMPTE À REBOURS
     Position : juste après le Hero pour créer l'urgence
═══════════════════════════════════════════════════ --}}
@if(isset($announcement) && $announcement && $announcement->isValid())
<section class="announce-section" id="announceSection"
         data-expires="{{ $announcement->expires_at->toIso8601String() }}"
         aria-label="Annonce spéciale">
    <div class="container">
        <div class="announce-inner">
            <div class="announce-text-col">
                <div class="announce-emoji-badge">
                    <span>{{ $announcement->emoji }}</span> Offre limitée
                </div>
                <h2 class="announce-title">{{ $announcement->message }}</h2>
                <p class="announce-subtitle">
                    Profitez de cette opportunité avant qu'il ne soit trop tard.
                    Inscrivez-vous maintenant et commencez votre formation dès aujourd'hui.
                </p>
                <a href="{{ route('register') }}" class="announce-cta">
                    <i class="bi bi-rocket-takeoff-fill" style="color:var(--vert);"></i>
                    J'en profite maintenant
                </a>
            </div>
            <div class="countdown-col">
                <div style="text-align:center;margin-bottom:.75rem;">
                    <span style="font-size:.72rem;font-weight:700;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:.1em;">
                        <i class="bi bi-hourglass-split me-1"></i>Temps restant
                    </span>
                </div>
                <div class="countdown-grid" id="countdownGrid">
                    <div class="cd-block" id="cd-days">
                        <span class="cd-val" id="cd-days-val">00</span>
                        <span class="cd-lbl">Jours</span>
                    </div>
                    <span class="cd-sep">:</span>
                    <div class="cd-block" id="cd-hours">
                        <span class="cd-val" id="cd-hours-val">00</span>
                        <span class="cd-lbl">Heures</span>
                    </div>
                    <span class="cd-sep">:</span>
                    <div class="cd-block" id="cd-mins">
                        <span class="cd-val" id="cd-mins-val">00</span>
                        <span class="cd-lbl">Minutes</span>
                    </div>
                    <span class="cd-sep">:</span>
                    <div class="cd-block" id="cd-secs">
                        <span class="cd-val" id="cd-secs-val">00</span>
                        <span class="cd-lbl">Secondes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════
     3. BANDE DE CONFIANCE
     Position : rassure immédiatement après le Hero
═══════════════════════════════════════════════════ --}}
<div class="trust-band">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-1 stagger-children">
            <div class="trust-item"><i class="bi bi-patch-check-fill" style="color:var(--vert);"></i>Formation agréée Côte d'Ivoire</div>
            <span class="trust-divider">·</span>
            <div class="trust-item"><i class="bi bi-shield-lock-fill" style="color:var(--rouge);"></i>Paiement sécurisé Wave CI</div>
            <span class="trust-divider">·</span>
            <div class="trust-item"><i class="bi bi-phone-fill" style="color:#3B82F6;"></i>100% accessible sur mobile</div>
            <span class="trust-divider">·</span>
            <div class="trust-item"><i class="bi bi-award-fill" style="color:var(--or);"></i>Certificat officiel de formation</div>
            <span class="trust-divider">·</span>
            <div class="trust-item"><i class="bi bi-headset" style="color:var(--vert);"></i>Support WhatsApp 7j/7</div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     4. STATS BAR — Preuve sociale chiffrée
═══════════════════════════════════════════════════ --}}
<div class="stats-bar">
    <div class="container">
        <div class="row g-0 text-center stagger-children">
            <div class="col-6 col-md-3 stat-item">
                <span class="number counter-num" data-target="1000">0</span><span class="number">+</span>
                <span class="label">Élèves formés</span>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <span class="number counter-num" data-target="98">0</span><span class="number">%</span>
                <span class="label">Taux de réussite</span>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <span class="number counter-num" data-target="7">0</span><span class="number"> ans</span>
                <span class="label">D'expérience</span>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <span class="number counter-num" data-target="24">0</span><span class="number">h/7</span>
                <span class="label">Accès en ligne</span>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     5. COMMENT ÇA MARCHE
     Position : Avancé — le visiteur veut savoir le processus
     avant tout le reste. Réduit l'hésitation.
═══════════════════════════════════════════════════ --}}
<section class="steps-section" id="comment-ca-marche" aria-label="Comment ça marche">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-tag"><i class="bi bi-map me-1"></i>Processus simple</span>
            <h2 class="section-title">Comment ça marche ?</h2>
            <p class="section-sub">En 3 étapes, vous passez de l'inscription à votre permis.</p>
        </div>
        <div class="row g-4 justify-content-center align-items-start">
            @php
            $steps = [
                ['num'=>'01','img'=>'/assets/images/person-add.svg','title'=>'Inscription gratuite','desc'=>'Créez votre compte en 2 minutes avec votre nom, prénom et numéro de téléphone. Aucun document requis pour débuter.','badge'=>'Gratuit & instantané','color'=>'var(--rouge)'],
                ['num'=>'02','img'=>'/assets/images/wave_logo.png','title'=>'Paiement Wave CI','desc'=>'Choisissez votre catégorie de permis et réglez vos frais de formation en toute sécurité via Wave CI. Reçu PDF généré automatiquement.','badge'=>'Paiement sécurisé','color'=>'var(--or)'],
                ['num'=>'03','img'=>'/assets/images/display-fill.svg','title'=>'Formation & Examen','desc'=>'Accédez aux vidéos, quiz interactifs et à votre coffre numérique. Suivez votre progression jusqu\'au jour de l\'examen.','badge'=>'Accès illimité 24h/7','color'=>'var(--vert)'],
            ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="col-md-4 reveal" style="transition-delay:{{ $i * 0.18 }}s">
                <div class="step-card">
                    <div class="step-num" style="background:linear-gradient(135deg,{{ $step['color'] }},{{ $step['color'] }}dd);">
                        <img src="{{ $step['img'] }}" alt="{{ $step['title'] }}" style="width:40px;height:40px;object-fit:contain;">
                    </div>
                    <h3 class="step-title">{{ $step['title'] }}</h3>
                    <p class="step-desc">{{ $step['desc'] }}</p>
                    <span class="step-badge" style="background:{{ $step['color'] }}1A;color:{{ $step['color'] }};">{{ $step['badge'] }}</span>
                </div>
            </div>
            @if($i < count($steps)-1)
            <div class="col-auto d-none d-md-flex step-connector reveal" style="transition-delay:{{ ($i * 0.18) + 0.09 }}s">
                <i class="bi bi-chevron-right" style="color:var(--border);font-size:1.8rem;"></i>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

{{-- Séparateur vague : blanc → bg --}}
<div class="wave-sep" style="background:#fff;">
    <svg viewBox="0 0 1440 48" preserveAspectRatio="none"><path d="M0,48 C360,0 1080,0 1440,48 L1440,48 L0,48 Z" fill="#F5F5F3"/></svg>
</div>

{{-- ═══════════════════════════════════════════════════
     6. FEATURES — Ce que vous obtenez concrètement
═══════════════════════════════════════════════════ --}}
<section class="features" id="features" aria-label="Services">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-tag">Notre programme</span>
            <h2 class="section-title">Tout ce dont vous avez besoin</h2>
            <p class="section-sub">Une plateforme complète pour préparer votre permis depuis chez vous.</p>
        </div>
        <div class="row g-4 stagger-children">
            @php
            $features = [
                ['bi-play-circle-fill','var(--rouge-p)','var(--rouge)','Vidéos de formation','Cours sur la signalisation, le code de la route et les techniques de conduite en Côte d\'Ivoire.'],
                ['bi-patch-question-fill','var(--vert-p)','var(--vert)','Quiz QCM interactifs','QCM chronométrés avec correction immédiate, explications et suivi de votre progression.'],
                ['bi-credit-card-fill','var(--or-p)','var(--or)','Paiement Wave','Paiement sécurisé via Wave CI avec reçu PDF généré et archivé automatiquement.'],
                ['bi-folder2-open','var(--rouge-p)','var(--rouge)','Coffre-fort numérique','Déposez et conservez vos pièces (CNI, photo, certificat médical) en toute sécurité.'],
            ];
            @endphp
            @foreach($features as $i => [$icon,$bg,$color,$title,$desc])
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon" style="background:{{ $bg }};color:{{ $color }};"><i class="bi {{ $icon }}"></i></div>
                    <div class="feature-title">{{ $title }}</div>
                    <p class="feature-desc">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Séparateur vague : bg → blanc --}}
<div class="wave-sep" style="background:var(--bg);">
    <svg viewBox="0 0 1440 48" preserveAspectRatio="none"><path d="M0,0 C360,48 1080,48 1440,0 L1440,48 L0,48 Z" fill="#fff"/></svg>
</div>

{{-- ═══════════════════════════════════════════════════
     7. TARIFS — Présenté tôt, pendant que l'intérêt est au pic
═══════════════════════════════════════════════════ --}}
<section class="pricing-section" id="tarifs" aria-label="Tarifs">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-tag"><i class="bi bi-tag-fill me-1"></i>Tarification transparente</span>
            <h2 class="section-title">Choisissez votre catégorie</h2>
            <p class="section-sub">Sélectionnez le permis qui vous convient et profitez d'une réduction en ligne.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 reveal from-scale">
                <div class="pricing-card">
                    <div class="pricing-badge">⭐ Réduction en ligne</div>
                    <div class="category-selector">
                        @foreach($categories as $index => $category)
                        <button class="category-btn {{ $index === 0 ? 'active' : '' }}"
                            data-category="{{ $category->code }}"
                            data-name="{{ $category->name }}"
                            data-description="{{ $category->description }}"
                            data-price="{{ $category->price }}"
                            data-discounted="{{ $category->discounted_price }}"
                            data-discount-percent="{{ $category->online_discount_percent }}"
                            onclick="selectCategory(this)">
                            {{ $category->code }}
                        </button>
                        @endforeach
                    </div>
                    <div class="pricing-name" id="categoryName">{{ $categories->first()?->name ?? 'Aucune catégorie' }}</div>
                    <div class="pricing-description" id="categoryDescription">{{ $categories->first()?->description ?? 'Sélectionnez une catégorie ci-dessus' }}</div>
                    <div class="pricing-price-container">
                        <div class="pricing-original-price" id="originalPrice">
                            Prix normal : <span id="originalPriceValue">{{ number_format($categories->first()?->price ?? 0, 0, ',', ' ') }}</span> XOF
                        </div>
                        <div class="pricing-discount-badge">
                            <i class="bi bi-percent"></i>
                            <span id="discountPercent">{{ $categories->first()?->online_discount_percent ?? 0 }}</span>% de réduction en ligne
                        </div>
                        <div class="pricing-price-row">
                            <div class="pricing-price"><sup>CFA</sup><span id="discountedPrice">{{ number_format($categories->first()?->discounted_price ?? 0, 0, ',', ' ') }}</span></div>
                            <div class="pricing-currency">XOF</div>
                        </div>
                    </div>
                    <ul class="pricing-list">
                        <li><div class="pi"><i class="bi bi-check2"></i></div>Médiathèque vidéo illimitée (Code + Conduite)</li>
                        <li><div class="pi"><i class="bi bi-check2"></i></div>Quiz QCM interactifs avec corrections</li>
                        <li><div class="pi"><i class="bi bi-check2"></i></div>Suivi de progression personnalisé</li>
                        <li><div class="pi"><i class="bi bi-check2"></i></div>Accès depuis mobile, tablette, PC</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-cta-main w-100 justify-content-center">
                        <i class="bi bi-rocket-takeoff-fill"></i>Commencez maintenant
                    </a>
                    <div class="pricing-guarantee">
                        <i class="bi bi-shield-check-fill" style="color:var(--vert);"></i>
                        Paiement 100% sécurisé via Wave CI
                    </div>
                    <div class="pricing-note">
                        <strong>NB :</strong> Les frais de retrait du permis ne sont pas inclus dans le montant de la formation initiale.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Séparateur vague : blanc → bg --}}
<div class="wave-sep" style="background:#fff;">
    <svg viewBox="0 0 1440 48" preserveAspectRatio="none"><path d="M0,48 C480,0 960,0 1440,48 L1440,48 L0,48 Z" fill="#F5F5F3"/></svg>
</div>

{{-- ═══════════════════════════════════════════════════
     8. QUI SOMMES-NOUS
     Position : Après le processus & les tarifs — la confiance
     se construit une fois l'intérêt déjà établi
═══════════════════════════════════════════════════ --}}
<section class="about-section" id="a-propos" aria-label="Qui sommes-nous">
    <div class="container" style="position:relative;z-index:1;">

        <div class="text-center mb-5 reveal">
            <span class="section-tag"><i class="bi bi-building me-1"></i>Notre histoire</span>
            <h2 class="section-title">Qui sommes-nous ?</h2>
            <p class="section-sub">Votre partenaire de confiance pour une conduite sûre et responsable, au cœur d'Abidjan.</p>
        </div>

        <div class="row g-4 align-items-stretch mb-4">
            <div class="col-lg-7 reveal from-right">
                <p class="about-intro">
                    Bienvenue chez <strong>l'Auto-École Le Chemin</strong>, installée
                    <strong>Avenue Adama Toungara, Plateau Dokui, Abobo</strong>
                    — à proximité de la Grande Pharmacie du Dokui et du Groupe Scolaire Sainte-Jeanne.
                    Depuis notre création, nous accompagnons les Abidjanais vers l'obtention de leur permis
                    avec rigueur, bienveillance et une pédagogie adaptée à chaque profil.
                </p>
                <div class="about-mission">
                    <strong><i class="bi bi-bullseye me-2" style="color:var(--vert);"></i>Notre Mission</strong><br>
                    Nous croyons que l'apprentissage de la conduite ne se résume pas à l'obtention
                    d'un <em>papier rose</em>. Notre objectif est de former des conducteurs
                    <strong>compétents, sereins et conscients des enjeux de la sécurité routière</strong>.
                    Nous adaptons nos méthodes à votre rythme pour maximiser vos chances de réussite aux examens.
                </div>
                <div class="d-flex flex-wrap gap-3 stagger-children">
                    <div style="background:var(--rouge-p);border-radius:12px;padding:.75rem 1.1rem;display:flex;align-items:center;gap:.6rem;flex:1;min-width:130px;">
                        <i class="bi bi-geo-alt-fill" style="color:var(--rouge);font-size:1.2rem;flex-shrink:0;"></i>
                        <div>
                            <div style="cursor:pointer;font-family:var(--font-d);font-weight:800;font-size:.88rem;color:var(--rouge);">Plateau Dokui</div>
                            <div style="font-size:.73rem;color:var(--texte-2);">Abobo, Abidjan</div>
                        </div>
                    </div>
                    <div style="background:var(--vert-p);border-radius:12px;padding:.75rem 1.1rem;display:flex;align-items:center;gap:.6rem;flex:1;min-width:130px;">
                        <i class="bi bi-award-fill" style="color:var(--vert);font-size:1.2rem;flex-shrink:0;"></i>
                        <div>
                            <div style="font-family:var(--font-d);font-weight:800;font-size:.88rem;color:var(--vert-c);">Agréée</div>
                            <div style="font-size:.73rem;color:var(--texte-2);">Formation officielle CI</div>
                        </div>
                    </div>
                    <div style="background:var(--or-p);border-radius:12px;padding:.75rem 1.1rem;display:flex;align-items:center;gap:.6rem;flex:1;min-width:130px;">
                        <i class="bi bi-people-fill" style="color:var(--or);font-size:1.2rem;flex-shrink:0;"></i>
                        <div>
                            <div style="font-family:var(--font-d);font-weight:800;font-size:.88rem;color:var(--texte);">1 000+</div>
                            <div style="font-size:.73rem;color:var(--texte-2);">Élèves formés</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 reveal from-left" style="transition-delay:.15s">
                <div class="director-card">
                    <img class="director-avatar" src="{{ asset('assets/images/director.jpeg') }}" alt="Director">
                    <div class="director-name">M. Marcelin Kohon</div>
                    <div class="director-title">Directeur — Auto-École Le Chemin</div>
                    <p class="director-quote">
                        "Notre équipe de moniteurs qualifiés met tout en œuvre pour que
                        <em>Le Chemin</em> vers votre permis soit le plus fluide possible.
                        Rejoignez-nous et prenez la route en toute confiance !"
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <div style="cursor:pointer;" class="director-location">
                            <i class="bi bi-geo-alt-fill"></i> Av. Adama Toungara, Abobo
                        </div>
                        <a href="https://wa.me/2250545160597" target="_blank" rel="noopener noreferrer"
                           style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(37,211,102,.2);border:1px solid rgba(37,211,102,.4);border-radius:50px;padding:.4rem .9rem;font-size:.78rem;color:#fff;font-weight:600;text-decoration:none;transition:.2s ease;">
                            <i class="bi bi-whatsapp" style="color:#25D366;"></i>Contacter
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="reveal" style="transition-delay:.1s">
            <div class="text-center mb-4">
                <span class="section-tag"><i class="bi bi-gift-fill me-1"></i>Nos offres</span>
                <h3 class="section-title" style="font-size:1.55rem;margin-bottom:.5rem;">Ce que nous vous offrons</h3>
            </div>
            <div class="row g-3 stagger-children">
                <div class="col-md-4">
                    <div class="offer-card rouge">
                        <div class="offer-icon" style="background:var(--rouge-p);color:var(--rouge);"><i class="bi bi-book-fill"></i></div>
                        <div class="offer-title">Formation complète</div>
                        <p class="offer-desc">Cours théoriques approfondis sur le <strong>Code de la Route</strong> et formation pratique rigoureuse en situation réelle sur les routes d'Abidjan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="offer-card vert">
                        <div class="offer-icon" style="background:var(--vert-p);color:var(--vert);"><i class="bi bi-card-checklist"></i></div>
                        <div class="offer-title">Permis toutes catégories</div>
                        <p class="offer-desc">Que vous souhaitiez moto, voiture ou poids lourd, nous avons la formation adaptée à votre projet.</p>
                        <div class="permit-badges">
                            <span class="permit-badge"><i class="bi bi-bicycle"></i>A — Moto</span>
                            <span class="permit-badge"><i class="bi bi-car-front-fill"></i>B — Voiture</span>
                            <span class="permit-badge" style="background:var(--vert-p);color:var(--vert-c);border-color:rgba(45,106,79,.15);"><i class="bi bi-truck-front-fill"></i>C/D/E</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="offer-card or">
                        <div class="offer-icon" style="background:var(--or-p);color:var(--or);"><i class="bi bi-stars"></i></div>
                        <div class="offer-title">Services post-permis</div>
                        <p class="offer-desc">Modules de <strong>perfectionnement à la conduite</strong> pour regagner en assurance au volant et sécuriser votre pratique quotidienne.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     9. APERÇU PLATEFORME — Démonstration concrète
═══════════════════════════════════════════════════ --}}
<section class="preview-section" aria-label="Aperçu de la plateforme">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-tag"><i class="bi bi-display me-1"></i>Aperçu</span>
            <h2 class="section-title">Découvrez votre espace élève</h2>
            <p class="section-sub">Voici à quoi ressemble la plateforme une fois connecté.</p>
        </div>
        <div class="preview-tabs justify-content-center mb-4">
            <button class="preview-tab active" onclick="showPreview('quiz', this)"><i class="bi bi-patch-question-fill me-1"></i>Quiz QCM</button>
            <button class="preview-tab" onclick="showPreview('dashboard', this)"><i class="bi bi-speedometer2 me-1"></i>Tableau de bord</button>
            <button class="preview-tab" onclick="showPreview('docs', this)"><i class="bi bi-folder2-open me-1"></i>Documents</button>
        </div>
        <div class="row justify-content-center reveal from-scale">
            <div class="col-lg-8">
                <div class="preview-frame active" id="preview-quiz">
                    <div class="preview-topbar">
                        <div class="preview-dot" style="background:#FF5F57;"></div>
                        <div class="preview-dot ms-1" style="background:#FEBC2E;"></div>
                        <div class="preview-dot ms-1" style="background:#28C840;"></div>
                        <span style="color:rgba(255,255,255,.5);font-size:.75rem;margin-left:1rem;">Quiz — Code de la Route</span>
                    </div>
                    <div class="preview-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-size:.78rem;color:var(--texte-2);font-weight:600;">Question 9 / 20</span>
                            <span style="font-size:.78rem;color:var(--rouge);font-weight:700;"><i class="bi bi-clock me-1"></i>22:15</span>
                        </div>
                        <div class="mock-q-progress"><div class="mock-q-bar"></div></div>
                        <div class="mock-q-text">À une intersection, qui a la priorité sur les autres véhicules ?</div>
                        <div class="mock-option">A. Le véhicule venant de gauche</div>
                        <div class="mock-option correct"><i class="bi bi-check-circle-fill me-2"></i>B. Le véhicule venant de droite ✓</div>
                        <div class="mock-option">C. Le véhicule le plus rapide</div>
                        <div class="mock-option">D. Le véhicule le plus lourd</div>
                        <div class="mt-2 p-2" style="background:var(--vert-p);border-radius:8px;font-size:.8rem;color:var(--vert-c);">
                            <i class="bi bi-lightbulb-fill me-1"></i><strong>Explication :</strong> En Côte d'Ivoire, la règle de priorité à droite s'applique sauf signalisation contraire.
                        </div>
                    </div>
                </div>
                <div class="preview-frame" id="preview-dashboard">
                    <div class="preview-topbar">
                        <div class="preview-dot" style="background:#FF5F57;"></div>
                        <div class="preview-dot ms-1" style="background:#FEBC2E;"></div>
                        <div class="preview-dot ms-1" style="background:#28C840;"></div>
                        <span style="color:rgba(255,255,255,.5);font-size:.75rem;margin-left:1rem;">Tableau de bord — Espace Élève</span>
                    </div>
                    <div class="preview-body">
                        <div class="mock-kpi-row">
                            <div class="mock-kpi"><div class="mk-val">14</div><div class="mk-lbl">Quiz passés</div></div>
                            <div class="mock-kpi"><div class="mk-val" style="color:var(--vert);">78%</div><div class="mk-lbl">Moy. Code</div></div>
                            <div class="mock-kpi"><div class="mk-val" style="color:var(--or);">3</div><div class="mk-lbl">Documents</div></div>
                            <div class="mock-kpi"><div class="mk-val" style="color:var(--vert);font-size:1rem;">✅</div><div class="mk-lbl">Actif</div></div>
                        </div>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;font-weight:700;"><span>Code de la route</span><span style="color:var(--rouge);">78%</span></div>
                            <div class="mock-prog-bar"><div class="mock-prog-fill" style="width:78%;background:var(--rouge);"></div></div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;font-weight:700;"><span>Conduite</span><span style="color:var(--vert);">65%</span></div>
                            <div class="mock-prog-bar"><div class="mock-prog-fill" style="width:65%;background:var(--vert);"></div></div>
                        </div>
                    </div>
                </div>
                <div class="preview-frame" id="preview-docs">
                    <div class="preview-topbar">
                        <div class="preview-dot" style="background:#FF5F57;"></div>
                        <div class="preview-dot ms-1" style="background:#FEBC2E;"></div>
                        <div class="preview-dot ms-1" style="background:#28C840;"></div>
                        <span style="color:rgba(255,255,255,.5);font-size:.75rem;margin-left:1rem;">Coffre-fort numérique — Documents</span>
                    </div>
                    <div class="preview-body">
                        <div class="mock-doc-row">
                            <div class="mock-doc-icon" style="background:var(--rouge-p);color:var(--rouge);"><i class="bi bi-person-badge-fill"></i></div>
                            <div><div style="font-weight:700;font-size:.85rem;">Carte Nationale d'Identité</div><div style="font-size:.72rem;color:var(--texte-2);">CNI_scan.pdf · 1.2 Mo</div></div>
                            <span class="mock-badge" style="background:var(--vert-p);color:var(--vert);">✅ Validé</span>
                        </div>
                        <div class="mock-doc-row">
                            <div class="mock-doc-icon" style="background:var(--or-p);color:var(--or);"><i class="bi bi-image-fill"></i></div>
                            <div><div style="font-weight:700;font-size:.85rem;">Photo d'identité</div><div style="font-size:.72rem;color:var(--texte-2);">photo_id.jpg · 450 Ko</div></div>
                            <span class="mock-badge" style="background:var(--vert-p);color:var(--vert);">✅ Validé</span>
                        </div>
                        <div class="mock-doc-row">
                            <div class="mock-doc-icon" style="background:var(--vert-p);color:var(--vert);"><i class="bi bi-file-medical-fill"></i></div>
                            <div><div style="font-weight:700;font-size:.85rem;">Certificat médical</div><div style="font-size:.72rem;color:var(--texte-2);">cert_medical.pdf · 800 Ko</div></div>
                            <span class="mock-badge" style="background:#FFF8E8;color:#78350F;">⏳ En attente</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     10. GALERIE — Preuve visuelle
═══════════════════════════════════════════════════ --}}
@if($galleryPhotos->isNotEmpty())
<section class="gallery-section" id="galerie" aria-label="Galerie photos">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-tag"><i class="bi bi-images me-1"></i>Notre quotidien</span>
            <h2 class="section-title">Galerie photos</h2>
            <p class="section-sub">Découvrez l'Auto-École Le Chemin en images — séances, moniteurs et véhicules.</p>
        </div>
        <div class="gallery-filters" id="galleryFilters">
            <button class="gf-btn active" data-filter="all"><i class="bi bi-grid-3x3-gap-fill me-1"></i>Tout</button>
            <button class="gf-btn" data-filter="seance"><i class="bi bi-car-front-fill me-1"></i>Séances</button>
            <button class="gf-btn" data-filter="moniteur"><i class="bi bi-person-badge-fill me-1"></i>Moniteurs</button>
            <button class="gf-btn" data-filter="voiture"><i class="bi bi-truck-front-fill me-1"></i>Voitures</button>
            <button class="gf-btn" data-filter="autre"><i class="bi bi-camera-fill me-1"></i>Autre</button>
        </div>
        <div class="gallery-grid" id="galleryGrid">
            @php $catLabels = ['seance'=>'Séance de conduite','moniteur'=>'Moniteurs','voiture'=>'Voitures','autre'=>'Autre']; @endphp
            @foreach($galleryPhotos as $photo)
            <div class="gallery-item" data-category="{{ $photo->category }}"
                 onclick="openLightbox('{{ $photo->image_url }}', '{{ addslashes($photo->title) }}', '{{ $catLabels[$photo->category] ?? $photo->category }}')">
                <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" loading="lazy">
                <div class="gallery-overlay">
                    <div>
                        <div class="gallery-overlay-title">{{ $photo->title }}</div>
                        <div class="gallery-overlay-cat"><i class="bi bi-tag-fill me-1"></i>{{ $catLabels[$photo->category] ?? $photo->category }}</div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="gallery-empty" id="galleryEmpty" style="display:none;">
                <i class="bi bi-search" style="font-size:2rem;display:block;margin-bottom:.5rem;color:#CBD5E1;"></i>
                Aucune photo dans cette catégorie.
            </div>
        </div>
    </div>
</section>

<div class="lightbox-bg" id="lightbox" onclick="closeLightbox(event)">
    <button class="lightbox-close" onclick="closeLightbox()" aria-label="Fermer"><i class="bi bi-x-lg"></i></button>
    <img src="" alt="" class="lightbox-img" id="lightboxImg">
    <div class="lightbox-caption" id="lightboxCaption"></div>
</div>
@endif

{{-- Séparateur vague : bg → blanc --}}
<div class="wave-sep" style="background:var(--bg);">
    <svg viewBox="0 0 1440 48" preserveAspectRatio="none"><path d="M0,0 C720,48 1440,0 1440,0 L1440,48 L0,48 Z" fill="#fff"/></svg>
</div>

{{-- ═══════════════════════════════════════════════════
     11. TÉMOIGNAGES — Preuve sociale juste avant le CTA
═══════════════════════════════════════════════════ --}}
<section class="testi-section" aria-label="Témoignages">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-tag"><i class="bi bi-chat-quote-fill me-1"></i>Témoignages</span>
            <h2 class="section-title">Ce que disent nos élèves</h2>
            <p class="section-sub">Plus de 1000 élèves nous ont fait confiance à Abidjan.</p>
        </div>
        <div class="row g-4 stagger-children">
            @php
            $testimonials = [
                ['K. Mamadou','Élève — Cocody',"J'ai obtenu mon permis au premier essai grâce aux quiz interactifs. Les explications après chaque question m'ont vraiment aidé à comprendre.",5],
                ['D. Fatoumata','Élève — Plateau',"Le paiement Wave était simple et en 2 minutes mon compte était activé. Le reçu PDF reçu immédiatement. Je recommande à tous.",5],
                ['T. Adama','Élève — Yopougon',"Les vidéos sont claires et bien expliquées. J'ai pu réviser depuis mon téléphone dans le transport. Une vraie révolution pour Abidjan.",5],
                ['S. Aminata','Élève — Abobo',"Au début j'avais peur de ne pas réussir. Avec les quiz, j'ai progressé semaine après semaine. Obtenu 92% à l'examen théorique !",5],
            ];
            @endphp
            @foreach($testimonials as $i => [$nom,$lieu,$texte,$note])
            <div class="col-md-6 col-lg-3">
                <div class="testi-card">
                    <div class="testi-stars">{{ str_repeat('★', $note) }}</div>
                    <p style="font-size:.88rem;color:var(--texte);line-height:1.7;margin-bottom:1rem;padding-top:.5rem;">"{{ $texte }}"</p>
                    <div style="display:flex;align-items:center;gap:.7rem;margin-top:auto;">
                        <div style="width:36px;height:36px;border-radius:50%;background:var(--rouge);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-family:var(--font-d);font-size:.85rem;flex-shrink:0;">
                            {{ strtoupper(substr($nom,0,1)) }}
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:.85rem;color:var(--texte);">{{ $nom }}</div>
                            <div style="font-size:.75rem;color:var(--texte-2);">{{ $lieu }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     12. FAQ — Lève les dernières objections avant la conversion
═══════════════════════════════════════════════════ --}}
<section class="faq-section" aria-label="Questions fréquentes">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-tag"><i class="bi bi-question-circle-fill me-1"></i>FAQ</span>
            <h2 class="section-title">Questions fréquentes</h2>
            <p class="section-sub">Tout ce que vous devez savoir avant de vous inscrire.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @php
                $faqs = [
                    ["Combien de temps dure la formation ?","La formation est à votre rythme, sans durée imposée. L'accès est illimité 24h/7. La plupart de nos élèves sont prêts pour l'examen en 4 à 8 semaines selon leur disponibilité."],
                    ["Le paiement Wave est-il vraiment sécurisé ?","Oui, à 100%. Nous utilisons l'API officielle Wave CI. Votre paiement est traité directement par Wave, et un reçu PDF officiel vous est remis instantanément. Nous ne stockons aucune donnée bancaire."],
                    ["Peut-on accéder à la formation depuis un téléphone ?","Absolument. La plateforme est entièrement responsive et optimisée pour mobile. Vous pouvez regarder les vidéos, faire les quiz et consulter vos documents depuis votre smartphone."],
                    ["Que faire si je rate l'examen théorique ?","Votre accès à la plateforme reste actif. Vous pouvez continuer à réviser, refaire les quiz et vous préparer pour une nouvelle tentative. Notre équipe est disponible sur WhatsApp pour vous accompagner."],
                    ["Comment déposer mes documents (CNI, photo, certificat médical) ?","Depuis votre espace élève, rendez-vous dans 'Mes documents'. Glissez-déposez vos fichiers (PDF, JPG, PNG jusqu'à 5 Mo). L'équipe de l'auto-école les validera dans les 24h ouvrées."],
                    ["Y a-t-il des cours pratiques de conduite inclus ?","La plateforme couvre la formation théorique (code de la route). Les cours pratiques de conduite se font physiquement avec nos moniteurs. Contactez-nous sur WhatsApp pour organiser vos créneaux de conduite."],
                ];
                @endphp
                @foreach($faqs as $i => [$q, $a])
                <div class="faq-item reveal" style="transition-delay:{{ $i * 0.07 }}s" id="faq-{{ $i }}">
                    <div class="faq-question" onclick="toggleFaq({{ $i }})">
                        <span>{{ $q }}</span>
                        <div class="faq-icon"><i class="bi bi-plus-lg"></i></div>
                    </div>
                    <div class="faq-answer" id="faq-answer-{{ $i }}">{{ $a }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     13. INFOS PRATIQUES — Contact & Localisation
═══════════════════════════════════════════════════ --}}
<section class="info-section" id="contact" aria-label="Informations pratiques">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-tag"><i class="bi bi-info-circle-fill me-1"></i>Informations pratiques</span>
            <h2 class="section-title">Venez nous voir</h2>
            <p class="section-sub">Retrouvez-nous à Abobo Dokui. Notre équipe vous accueille du lundi au samedi.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="row g-4 h-100">
                    <div class="col-12">
                        <div class="info-card reveal from-right">
                            <div class="info-card-header">
                                <div class="info-card-icon" style="background:var(--rouge);"><i class="bi bi-telephone-fill" style="color:#fff;"></i></div>
                                <h3 class="info-card-title">Contact</h3>
                            </div>
                            <div class="info-card-body">
                                <a href="tel:+2252724318838" class="contact-row">
                                    <div class="contact-row-icon" style="background:var(--vert);"><i class="bi bi-telephone-fill"></i></div>
                                    <span class="contact-row-text">+225 27 24 31 88 38</span>
                                </a>
                                <a href="https://wa.me/2250545160597" target="_blank" class="contact-row">
                                    <div class="contact-row-icon" style="background:#25D366;"><i class="bi bi-whatsapp"></i></div>
                                    <span class="contact-row-text"><strong>05 45 16 05 97</strong><br>WhatsApp & Appel 7j/7</span>
                                </a>
                                <div class="contact-row">
                                    <div class="contact-row-icon" style="background:#F97316;"><i class="bi bi-geo-alt-fill"></i></div>
                                    <span class="contact-row-text">Non loin de la Grande Pharmacie du Dokui, Avenue ADAMA TOUNGARA — Plateau Dokui, Abobo, Abidjan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-card reveal from-right" style="transition-delay:.15s">
                            <div class="info-card-header">
                                <div class="info-card-icon" style="background:var(--vert);"><i class="bi bi-clock-fill" style="color:#fff;"></i></div>
                                <h3 class="info-card-title">Horaires d'ouverture</h3>
                            </div>
                            <div class="info-card-body">
                                @php
                                $horaires = [['Lundi','08:00 - 17:00',false],['Mardi','08:00 - 17:00',false],['Mercredi','08:00 - 17:00',false],['Jeudi','08:00 - 17:00',false],['Vendredi','08:00 - 17:00',false],['Samedi','09:00 - 13:00',false],['Dimanche','Fermé',true]];
                                $mapping=[0=>6,1=>0,2=>1,3=>2,4=>3,5=>4,6=>5];
                                $todayIdx=$mapping[now()->dayOfWeek]??-1;
                                @endphp
                                @foreach($horaires as $i => [$jour,$heure,$ferme])
                                <div class="hours-row {{ $i===$todayIdx?'today':'' }} {{ $ferme?'ferme':'' }}">
                                    <span class="hours-day">@if($i===$todayIdx)<i class="bi bi-circle-fill" style="font-size:.4rem;color:var(--vert);"></i>@endif{{ $jour }}</span>
                                    <span class="hours-time">{{ $heure }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 reveal from-left" style="transition-delay:.1s">
                <div class="map-card h-100">
                    <div class="map-card-header" id="localisation">
                        <div class="info-card-icon" style="background:var(--rouge);"><i class="bi bi-pin-map-fill" style="color:#fff;"></i></div>
                        <h3 class="info-card-title">Localisation — Abobo Dokui, Abidjan</h3>
                    </div>
                    <div style="padding:0 1.5rem;">
                        <div style="border-radius:14px;overflow:hidden;border:1px solid var(--border);margin-top:.25rem;">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.1!2d-4.003776!3d5.408777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMjQnMzEuNiJOIDTCsDAwJzEzLjYiVw!5e0!3m2!1sfr!2sci!4v1699000000000"
                                width="100%" height="340" style="border:0;display:block;" allowfullscreen="" loading="lazy" title="Auto-École Le Chemin"></iframe>
                        </div>
                    </div>
                    <div class="map-gps-btns">
                        <a href="https://www.google.com/maps/dir/?api=1&destination=5.408777,-4.003776" target="_blank" rel="noopener" class="map-btn map-btn-google"><i class="bi bi-map-fill"></i>Itinéraire Google Maps</a>
                        <a href="https://waze.com/ul?ll=5.408777,-4.003776&navigate=yes" target="_blank" rel="noopener" class="map-btn map-btn-waze"><i class="bi bi-car-front-fill"></i>Itinéraire Waze</a>
                    </div>
                    <div style="padding:.25rem 1.5rem 1.25rem;">
                        <div style="background:var(--bg);border-radius:12px;padding:.85rem 1rem;display:flex;align-items:flex-start;gap:.65rem;">
                            <i class="bi bi-geo-alt-fill" style="color:var(--rouge);font-size:1rem;margin-top:.1rem;flex-shrink:0;"></i>
                            <span style="font-size:.82rem;color:var(--texte-2);line-height:1.55;">Non loin de la Grande Pharmacie du Dokui, Avenue ADAMA TOUNGARA près Groupe Scolaire Sainte Jeanne — Plateau Dokui Abobo, Abidjan, Côte d'Ivoire</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     14. CTA FINAL — Dernier appel à l'action
═══════════════════════════════════════════════════ --}}
<section class="cta-section" aria-label="Inscription">
    <div class="container" style="position:relative;z-index:1;">
        <div class="reveal from-scale">
            <h2 class="section-title" style="color:#fff;font-size:2.4rem;">Prêt à décrocher votre permis ?</h2>
            <p style="color:rgba(255,255,255,.82);max-width:500px;margin:.75rem auto 2rem;font-size:1rem;line-height:1.7;">
                Plus de <strong style="color:#fff;">1000 élèves</strong> nous font déjà confiance à Abidjan.
                Rejoignez-les et commencez votre formation dès aujourd'hui.
            </p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('register') }}" class="btn-hero-primary" style="font-size:1.05rem;padding:1rem 2.5rem;">
                    <i class="bi bi-rocket-takeoff-fill" style="color:var(--vert);"></i>Créer mon compte gratuitement
                </a>
                <a href="https://wa.me/2252724318838?text=Bonjour%2C%20je%20souhaite%20des%20informations%20sur%20la%20formation."
                   target="_blank"
                   style="background:rgba(255,255,255,.15);border:2px solid rgba(255,255,255,.35);color:#fff;font-size:1rem;padding:.95rem 2rem;border-radius:12px;text-decoration:none;display:inline-flex;align-items:center;gap:.5rem;font-weight:700;transition:.25s ease;">
                    <i class="bi bi-whatsapp" style="color:#25D366;"></i>Nous contacter
                </a>
            </div>
            <p style="color:rgba(255,255,255,.5);font-size:.8rem;margin-top:1.25rem;">
                <i class="bi bi-shield-check me-1"></i>Inscription gratuite · Paiement sécurisé Wave · Annulation possible
            </p>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
/* ── Compteur flottant ──────────────────────────── */
(function () {
    const el = document.getElementById('viewCount');
    if (!el) return;
    const t = parseInt(el.dataset.target, 10),
          ease = x => 1 - Math.pow(1 - x, 3);
    setTimeout(() => {
        const s = performance.now();
        (function tick(n) {
            const p = Math.min((n - s) / 2200, 1);
            el.textContent = Math.round(t * ease(p)).toLocaleString('fr-FR');
            if (p < 1) requestAnimationFrame(tick);
        })(performance.now());
    }, 500);
})();

/* ── Compteurs stats bar ────────────────────────── */
const cO = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (!e.isIntersecting) return;
        const el = e.target, t = parseInt(el.dataset.target, 10);
        if (isNaN(t)) return;
        const s = performance.now(), ease = v => 1 - Math.pow(1 - v, 3);
        (function tick(n) {
            const p = Math.min((n - s) / 1400, 1);
            el.textContent = Math.round(t * ease(p));
            if (p < 1) requestAnimationFrame(tick);
        })(s);
        cO.unobserve(el);
    });
}, { threshold: .4 });
document.querySelectorAll('.counter-num').forEach(el => cO.observe(el));

/* ── Scroll reveal (reveal + stagger-children) ── */
const rO = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            rO.unobserve(e.target);
        }
    });
}, { threshold: .08, rootMargin: '0px 0px -50px 0px' });
document.querySelectorAll('.reveal, .stagger-children').forEach(el => rO.observe(el));

/* ── Sélecteur de catégorie ─────────────────────── */
function selectCategory(btn) {
    document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('categoryName').textContent        = btn.dataset.name;
    document.getElementById('categoryDescription').textContent = btn.dataset.description;
    document.getElementById('originalPriceValue').textContent  = formatPrice(parseFloat(btn.dataset.price));
    document.getElementById('discountedPrice').textContent     = formatPrice(parseFloat(btn.dataset.discounted));
    document.getElementById('discountPercent').textContent     = btn.dataset.discountPercent;
}
function formatPrice(price) { return Math.round(price).toLocaleString('fr-FR'); }

/* ── Aperçu plateforme ──────────────────────────── */
function showPreview(id, btn) {
    document.querySelectorAll('.preview-frame').forEach(f => f.classList.remove('active'));
    document.querySelectorAll('.preview-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('preview-' + id).classList.add('active');
    btn.classList.add('active');
}

/* ── FAQ accordéon ──────────────────────────────── */
function toggleFaq(i) {
    const item   = document.getElementById('faq-' + i);
    const answer = document.getElementById('faq-answer-' + i);
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(f => {
        f.classList.remove('open');
        f.querySelector('.faq-answer').classList.remove('open');
    });
    if (!isOpen) { item.classList.add('open'); answer.classList.add('open'); }
}

/* ── GALERIE ──────────────────────────────────── */
(function () {
    const items = document.querySelectorAll('.gallery-item');
    if (!items.length) return;

    const io = new IntersectionObserver(entries => {
        entries.forEach((e, i) => {
            if (e.isIntersecting) {
                setTimeout(() => e.target.classList.add('visible'), i * 55);
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
    items.forEach(item => io.observe(item));

    const filterBtns  = document.querySelectorAll('.gf-btn');
    const emptyNotice = document.getElementById('galleryEmpty');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            let visible  = 0;
            items.forEach(item => {
                const match = filter === 'all' || item.dataset.category === filter;
                if (match) {
                    item.classList.remove('hidden');
                    if (!item.classList.contains('visible')) item.classList.add('visible');
                    visible++;
                } else {
                    item.classList.add('hidden');
                }
            });
            if (emptyNotice) emptyNotice.style.display = visible === 0 ? 'block' : 'none';
        });
    });

    window.openLightbox = function (src, title, cat) {
        const lb  = document.getElementById('lightbox');
        const img = document.getElementById('lightboxImg');
        const cap = document.getElementById('lightboxCaption');
        img.src = src; img.alt = title;
        cap.textContent = title + ' — ' + cat;
        lb.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.closeLightbox = function (e) {
        if (e && e.target !== document.getElementById('lightbox') &&
            !e.target.closest('.lightbox-close')) return;
        const lb = document.getElementById('lightbox');
        lb.classList.remove('open');
        document.body.style.overflow = '';
        setTimeout(() => { document.getElementById('lightboxImg').src = ''; }, 300);
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') window.closeLightbox({ target: document.getElementById('lightbox') });
    });
})();

/* ── COUNTDOWN + masquage automatique ─────────── */
(function () {
    const section = document.getElementById('announceSection');
    if (!section) return;
    const expiry = new Date(section.dataset.expires).getTime();
    function pad(n) { return String(n).padStart(2, '0'); }

    function hideSections() {
        section.style.transition   = 'opacity .8s ease, max-height 1s ease, padding .8s ease';
        section.style.opacity      = '0';
        section.style.maxHeight    = '0';
        section.style.padding      = '0';
        section.style.overflow     = 'hidden';
        const bar = document.getElementById('topBarAnnounce');
        if (bar) {
            bar.style.transition = 'opacity .6s ease, max-height .6s ease';
            bar.style.opacity    = '0';
            bar.style.maxHeight  = '0';
            bar.style.padding    = '0';
            bar.style.overflow   = 'hidden';
        }
    }

    function tick() {
        const diff = expiry - Date.now();
        if (diff <= 0) {
            ['days','hours','mins','secs'].forEach(u => {
                const el = document.getElementById('cd-' + u + '-val');
                if (el) el.textContent = '00';
            });
            hideSections();
            return;
        }
        document.getElementById('cd-days-val').textContent  = pad(Math.floor(diff / 86400000));
        document.getElementById('cd-hours-val').textContent = pad(Math.floor((diff % 86400000) / 3600000));
        document.getElementById('cd-mins-val').textContent  = pad(Math.floor((diff % 3600000)  / 60000));
        document.getElementById('cd-secs-val').textContent  = pad(Math.floor((diff % 60000)    / 1000));
        const secBlock = document.getElementById('cd-secs');
        if (secBlock) {
            secBlock.classList.add('pulse');
            setTimeout(() => secBlock.classList.remove('pulse'), 200);
        }
        setTimeout(tick, 1000);
    }
    tick();
})();
</script>
@endsection