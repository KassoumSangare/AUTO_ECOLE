<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#AF2636">
    {{-- Pas d'indexation pour les pages connectées ══ --}}
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Espace Élève') — Auto-École Le Chemin</title>

    {{-- ══ Favicon ══ --}}
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/logo.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.jpeg') }}">

    {{-- ══ 1. Preconnect ══ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- ══ 2. Google Fonts — Poppins + Syne ══ --}}
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    {{-- ══ 3. Bootstrap CSS ══ --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- ══ 4. Bootstrap Icons — une seule fois (doublon supprimé) ══ --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- ══ 5. CSS custom ══ --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        :root {
            --rouge: #AF2636;
            --rouge-c: #8A1E2B;
            --rouge-p: #FFF1F2;
            --vert: #2D6A4F;
            --vert-c: #1B4332;
            --vert-p: #F0F7F4;
            --or: #C5A059;
            --or-c: #D9B36A;
            --or-p: #FEFCE8;
            --blanc: #FFFFFF;
            --fond: #FBFBF9;
            --texte: #1F2937;
            --texte-2: #6B7280;
            --border: #E5E7EB;
            --bg: #F5F5F3;
            --bleu: #AF2636;
            --bleu-c: #8A1E2B;
            --bleu-pale: #FFF1F2;
            --or-clair: #D9B36A;
            --or-pale: #FEFCE8;
            --gris-100: #F5F5F3;
            --gris-200: #E5E7EB;
            --gris-500: #6B7280;
            --r-sm: 8px;
            --r-md: 14px;
            --r-lg: 20px;
            --r: 12px;
            --shadow-sm: 0 2px 8px rgba(175, 38, 54, .06);
            --shadow-md: 0 8px 24px rgba(175, 38, 54, .10);
            --shadow-lg: 0 16px 48px rgba(175, 38, 54, .14);
            --shadow-or: 0 8px 28px rgba(197, 160, 89, .35);
            --trans: .3s cubic-bezier(.4, 0, .2, 1);
            --font-d: 'Montserrat', sans-serif;
            --font-b: 'Open Sans', sans-serif;
            --sidebar-w: 258px;
            --topbar-h: 58px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: var(--font-b) !important;
            background: var(--bg);
            color: var(--texte);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-d,
        .page-title,
        .kpi-val,
        .card-d-title,
        .section-title,
        .brand-name,
        .pcard-title,
        .auth-title {
            font-family: var(--font-d) !important;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* ══ KEYFRAMES ══ */
        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(32px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeLeft {
            from {
                opacity: 0;
                transform: translateX(32px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(.93)
            }

            to {
                opacity: 1;
                transform: scale(1)
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-8px)
            }
        }

        @keyframes shimmer {
            from {
                background-position: -600px 0
            }

            to {
                background-position: 600px 0
            }
        }

        @keyframes road-scroll {
            from {
                background-position: 0 0
            }

            to {
                background-position: 0 200px
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        @keyframes wa-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, .6), 0 4px 20px rgba(37, 211, 102, .45);
            }

            70% {
                box-shadow: 0 0 0 16px rgba(37, 211, 102, 0), 0 4px 20px rgba(37, 211, 102, .45);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0), 0 4px 20px rgba(37, 211, 102, .45);
            }
        }

        @keyframes wa-bounce {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            25% {
                transform: translateY(-7px) scale(1.06);
            }

            50% {
                transform: translateY(-3px) scale(1.03);
            }

            75% {
                transform: translateY(-5px) scale(1.04);
            }
        }

        /* ══ ANIMATIONS ══ */
        .anim-fade-in {
            animation: fadeIn .5s ease both;
        }

        .anim-fade-up {
            animation: fadeUp .6s cubic-bezier(.4, 0, .2, 1) both;
        }

        .anim-fade-down {
            animation: fadeDown .5s ease both;
        }

        .anim-fade-left {
            animation: fadeLeft .6s cubic-bezier(.4, 0, .2, 1) both;
        }

        .anim-scale-in {
            animation: scaleIn .5s cubic-bezier(.4, 0, .2, 1) both;
        }

        .anim-float {
            animation: float 3.5s ease-in-out infinite;
        }

        .delay-1 {
            animation-delay: .1s
        }

        .delay-2 {
            animation-delay: .2s
        }

        .delay-3 {
            animation-delay: .3s
        }

        .delay-4 {
            animation-delay: .4s
        }

        .delay-5 {
            animation-delay: .5s
        }

        .delay-6 {
            animation-delay: .6s
        }

        .delay-7 {
            animation-delay: .7s
        }

        /* ══ SCROLL REVEAL ══ */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .65s cubic-bezier(.4, 0, .2, 1), transform .65s cubic-bezier(.4, 0, .2, 1);
        }

        .reveal.from-left {
            transform: translateX(-28px);
        }

        .reveal.from-right {
            transform: translateX(28px);
        }

        .reveal.from-scale {
            transform: scale(.95);
        }

        .reveal.visible {
            opacity: 1;
            transform: none;
        }

        .stagger>* {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .5s ease, transform .5s ease;
        }

        .stagger.visible>*:nth-child(1) {
            transition-delay: 0s;
            opacity: 1;
            transform: none;
        }

        .stagger.visible>*:nth-child(2) {
            transition-delay: .1s;
            opacity: 1;
            transform: none;
        }

        .stagger.visible>*:nth-child(3) {
            transition-delay: .2s;
            opacity: 1;
            transform: none;
        }

        .stagger.visible>*:nth-child(4) {
            transition-delay: .3s;
            opacity: 1;
            transform: none;
        }

        .stagger.visible>*:nth-child(5) {
            transition-delay: .4s;
            opacity: 1;
            transform: none;
        }

        .stagger.visible>*:nth-child(6) {
            transition-delay: .5s;
            opacity: 1;
            transform: none;
        }

        /* ══ SKELETON ══ */
        .skeleton {
            background: linear-gradient(90deg, #F0F4FA 25%, #E5EAFF 50%, #F0F4FA 75%);
            background-size: 600px 100%;
            animation: shimmer 1.4s infinite;
            border-radius: var(--r-sm);
        }

        /* ══ CARDS ══ */
        .card-lc {
            background: #fff;
            border-radius: var(--r-md);
            border: 1.5px solid var(--gris-200);
            transition: transform var(--trans), box-shadow var(--trans), border-color var(--trans);
        }

        .card-lc:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: rgba(212, 168, 67, .3);
        }

        /* ══ BUTTONS ══ */
        .btn-primary-lc {
            background: linear-gradient(135deg, var(--or), var(--or-clair));
            color: var(--rouge);
            font-family: var(--font-d);
            font-weight: 800;
            border: none;
            border-radius: var(--r-md);
            padding: .85rem 2rem;
            font-size: .98rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            transition: transform var(--trans), box-shadow var(--trans);
            box-shadow: var(--shadow-or);
            cursor: pointer;
        }

        .btn-primary-lc:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(212, 168, 67, .5);
            color: var(--rouge);
        }

        .btn-dark-lc {
            background: linear-gradient(135deg, var(--rouge), var(--rouge-c));
            color: #fff;
            font-family: var(--font-d);
            font-weight: 700;
            border: none;
            border-radius: var(--r-md);
            padding: .8rem 1.75rem;
            font-size: .93rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            transition: transform var(--trans), box-shadow var(--trans);
            cursor: pointer;
        }

        .btn-dark-lc:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: #fff;
        }

        .btn-ghost-lc {
            border: 2px solid rgba(255, 255, 255, .3);
            color: rgba(255, 255, 255, .9);
            font-weight: 600;
            border-radius: var(--r-md);
            padding: .8rem 1.75rem;
            font-size: .93rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            transition: all var(--trans);
        }

        .btn-ghost-lc:hover {
            border-color: var(--or);
            color: var(--or);
            background: rgba(212, 168, 67, .08);
        }

        /* ══ VIEWS COUNTER ══ */
        .views-counter {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            background: rgba(255, 255, 255, .1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, .18);
            color: rgba(255, 255, 255, .9);
            font-size: .82rem;
            padding: .45rem 1rem;
            border-radius: 50px;
            transition: background var(--trans);
        }

        .views-counter .count {
            font-family: var(--font-d);
            font-weight: 800;
            color: var(--or);
            font-size: .98rem;
            font-variant-numeric: tabular-nums;
            min-width: 48px;
            text-align: center;
        }

        /* ══ HERO ROAD ══ */
        .hero-road::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: repeating-linear-gradient(90deg, transparent 48.5%, rgba(212, 168, 67, .09) 49%, rgba(212, 168, 67, .09) 51%, transparent 51.5%);
            animation: road-scroll 10s linear infinite;
        }

        /* ══ LOGO ══ */
        .nav-brand-logo {
            width: 60px;
            height: 55px;
            border-radius: 10px;
            background: #fff;
            object-fit: cover;
            object-position: center;
            flex-shrink: 0;
            border: 1px solid rgba(0, 0, 0, .05);
        }

        /* ══ SIDEBAR ══ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--rouge-c);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 900;
            display: flex;
            flex-direction: column;
            border-right: 3px solid var(--vert);
            transition: transform .3s cubic-bezier(.4, 0, .2, 1);
        }

        .sidebar-brand {
            padding: 1.3rem 1.2rem .85rem;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            gap: .6rem;
            text-decoration: none;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #fff;
            color: var(--rouge);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-d) !important;
            font-weight: 900;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .brand-name {
            font-family: var(--font-d) !important;
            font-weight: 800;
            font-size: 1.1rem;
            color: #fff;
            line-height: 1.1;
        }

        .brand-name span {
            color: var(--vert-p);
        }

        .sidebar-nav {
            flex: 1;
            padding: .75rem 0;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 0;
        }

        .sidebar-label {
            font-size: .65rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: rgba(255, 255, 255, .3);
            padding: .75rem 1.2rem .25rem;
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .65rem 1.2rem;
            color: rgba(255, 255, 255, .72);
            text-decoration: none;
            font-size: .87rem;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all var(--trans);
            margin: 1px 0;
            position: relative;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: #fff;
            background: rgba(255, 255, 255, .09);
            border-left-color: var(--or);
        }

        .sidebar-link.active {
            font-weight: 700;
        }

        .sidebar-link i {
            font-size: 1.05rem;
            width: 1.1rem;
            text-align: center;
            flex-shrink: 0;
        }

        .notif-dot {
            width: 7px;
            height: 7px;
            background: var(--or);
            border-radius: 50%;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .sidebar-footer {
            padding: .85rem 1.2rem;
            border-top: 1px solid rgba(255, 255, 255, .08);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: rgba(255, 255, 255, .85);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--or);
            color: var(--rouge-c);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: .85rem;
            flex-shrink: 0;
            font-family: var(--font-d) !important;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: .5rem;
            width: 100%;
            background: rgba(255, 255, 255, .08);
            border: none;
            border-radius: 8px;
            color: rgba(255, 255, 255, .75);
            padding: .5rem .75rem;
            font-size: .85rem;
            cursor: pointer;
            transition: background var(--trans), color var(--trans);
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, .15);
            color: #fff;
        }

        /* ══ MAIN ══ */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left .3s ease;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            border-top: 3px solid var(--rouge);
            padding: 0 1.6rem;
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 800;
            box-shadow: 0 1px 8px rgba(0, 0, 0, .04);
        }

        .page-title {
            font-family: var(--font-d) !important;
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--texte);
            margin: 0;
        }

        .main-content {
            padding: 1.5rem;
            flex: 1;
        }

        /* ══ ALERTES ══ */
        .alert {
            border: none;
            border-radius: 12px;
            font-size: .88rem;
        }

        .alert-success {
            background: var(--vert-p);
            color: var(--vert-c);
            border-left: 3px solid var(--vert);
        }

        .alert-warning {
            background: #FEFCE8;
            color: #854D0E;
            border-left: 3px solid #CA8A04;
        }

        .alert-danger {
            background: var(--rouge-p);
            color: var(--rouge-c);
            border-left: 3px solid var(--rouge);
        }

        .alert-info {
            background: #EFF6FF;
            color: #1E40AF;
            border-left: 3px solid #3B82F6;
        }

        /* ══ WHATSAPP ══ */
        .whatsapp-float {
            position: fixed;
            bottom: 22px;
            right: 22px;
            width: 50px;
            height: 50px;
            background: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(37, 211, 102, .4);
            animation: wa-pulse 2.2s ease-out infinite, wa-bounce 5s ease-in-out infinite 2s;
            transition: transform var(--trans), box-shadow var(--trans);
            will-change: transform;
        }

        .whatsapp-float:hover {
            transform: scale(1.15) translateY(-4px) !important;
            box-shadow: 0 10px 36px rgba(37, 211, 102, .7) !important;
            animation-play-state: paused;
        }

        .whatsapp-float i {
            font-size: 1.55rem;
            color: #fff;
            transition: transform var(--trans);
        }

        .whatsapp-float:hover i {
            transform: rotate(-12deg) scale(1.1);
        }

        .whatsapp-float::before {
            content: 'Nous contacter';
            position: absolute;
            right: 70px;
            background: var(--rouge);
            color: #fff;
            font-family: var(--font-b);
            font-size: .76rem;
            font-weight: 600;
            padding: .35rem .8rem;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            transform: translateX(6px);
            transition: opacity .25s ease, transform .25s ease;
            pointer-events: none;
            box-shadow: var(--shadow-sm);
        }

        .whatsapp-float::after {
            content: '';
            position: absolute;
            right: 62px;
            border: 5px solid transparent;
            border-left-color: var(--rouge);
            opacity: 0;
            transition: opacity .25s ease;
        }

        .whatsapp-float:hover::before {
            opacity: 1;
            transform: translateX(0);
        }

        .whatsapp-float:hover::after {
            opacity: 1;
        }

        /* ══ SIDEBAR OVERLAY ══ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 850;
            opacity: 0;
            transition: opacity .3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* ══ SCROLLBAR ══ */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #F0F4FA;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--rouge-c);
        }

        :focus-visible {
            outline: 2px solid var(--or);
            outline-offset: 3px;
            border-radius: 4px;
        }

        /* ══ RESPONSIVE ══ */
        @media (max-width:575.98px) {
            .whatsapp-float {
                width: 44px;
                height: 44px;
                bottom: 14px;
                right: 14px;
            }

            .whatsapp-float i {
                font-size: 1.35rem;
            }

            .whatsapp-float::before,
            .whatsapp-float::after {
                display: none;
            }

            .btn-primary-lc,
            .btn-dark-lc {
                padding: .72rem 1.4rem;
                font-size: .88rem;
            }

            .sidebar {
                width: 100% !important;
            }
        }

        @media (max-width:768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .3s cubic-bezier(.4, 0, .2, 1);
                border-right: none;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .main-content {
                padding: 1rem;
            }

            .topbar {
                padding: 0 1rem;
                border-top-width: 2px;
            }
        }

        @media (hover:none) {

            .card-lc:hover,
            .btn-primary-lc:hover,
            .btn-dark-lc:hover {
                transform: none;
                box-shadow: none;
            }

            .whatsapp-float {
                animation: wa-pulse 2.2s ease-out infinite !important;
            }
        }

        @media (prefers-reduced-motion:reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }

            .whatsapp-float {
                animation: none !important;
                box-shadow: 0 4px 20px rgba(37, 211, 102, .45);
            }

            .reveal {
                opacity: 1 !important;
                transform: none !important;
            }
        }

        @media print {

            .whatsapp-float,
            .sidebar,
            .topbar {
                display: none !important;
            }

            .main-wrapper {
                margin-left: 0 !important;
            }
        }
    </style>

    @yield('head')
</head>

<body>

    {{-- ══ SIDEBAR ══ --}}
    <aside class="sidebar" id="sidebar" aria-label="Navigation latérale">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <picture>
                <source srcset="{{ asset('assets/images/logo.jpeg') }}" type="image/webp">
                <img src="{{ asset('assets/images/logo.jpeg') }}" class="nav-brand-logo" alt="Auto-École Le Chemin"
                    width="60" height="55" loading="lazy">
            </picture>
            <div class="brand-name">Le <span>Chemin</span></div>
        </a>

        <nav class="sidebar-nav" aria-label="Menu principal">
            @if(auth()->user()->isAdmin())
                {{-- MENU ADMIN --}}
                <div class="sidebar-label">Administration</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link @active('admin/tableau*')">
                    <i class="bi bi-speedometer2"></i><span>Tableau de bord</span>
                </a>
                <a href="{{ route('admin.permit-categories.index') }}"
                    class="sidebar-link @active('admin/permit-categories*')">
                    <i class="bi bi-list-task"></i><span>Catégories</span>
                </a>
                <a href="{{ route('admin.eleves.index') }}" class="sidebar-link @active('admin/eleves*')">
                    <i class="bi bi-people-fill"></i><span>Élèves & CRM</span>
                </a>
                <a href="{{ route('admin.documents.index') }}" class="sidebar-link @active('admin/documents*')">
                    <i class="bi bi-folder2-open"></i><span>Documents</span>
                </a>
                <a href="{{ route('admin.reporting.index') }}" class="sidebar-link @active('admin/reporting*')">
                    <i class="bi bi-bar-chart-line-fill"></i><span>Reporting</span>
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="sidebar-link @active('admin/gallery*')">
                    <i class="bi bi-images"></i><span>Galerie</span>
                </a>
                <a href="{{ route('admin.qcms.index') }}" class="sidebar-link @active('admin/qcms*')">
                    <i class="bi bi-patch-question-fill"></i><span>QCM</span>
                </a>
                <a href="{{ route('admin.announcements.index') }}" class="sidebar-link @active('admin/announcements*')">
                    <i class="bi bi-megaphone-fill"></i><span>Annonces</span>
                </a>
                <div class="sidebar-label">Paramètres</div>
                <a href="{{ route('profile.edit') }}" class="sidebar-link @active('profile*')">
                    <i class="bi bi-person-circle"></i><span>Mon Profil</span>
                </a>
            @else
                {{-- MENU ÉLÈVE --}}
                <div class="sidebar-label">Mon parcours</div>
                <a href="{{ route('eleve.dashboard') }}" class="sidebar-link @active('espace-eleve/tableau*')">
                    <i class="bi bi-house-fill"></i><span>Tableau de bord</span>
                </a>
                <a href="{{ route('eleve.payment') }}" class="sidebar-link @active('espace-eleve/paiement*')">
                    <i class="bi bi-credit-card-fill"></i><span>Paiement</span>
                    @if(!auth()->user()->hasPaid())<span class="notif-dot"></span>@endif
                </a>
                <a href="{{ route('eleve.mediatheque') }}" class="sidebar-link @active('espace-eleve/mediatheque*')">
                    <i class="bi bi-play-circle-fill"></i><span>Médiathèque</span>
                </a>
                <a href="{{ route('eleve.quiz') }}" class="sidebar-link @active('espace-eleve/quiz*')">
                    <i class="bi bi-patch-question-fill"></i><span>Quiz QCM</span>
                </a>
                <a href="{{ route('eleve.documents') }}" class="sidebar-link @active('espace-eleve/documents*')">
                    <i class="bi bi-file-earmark-arrow-up-fill"></i><span>Mes documents</span>
                </a>
                <div class="sidebar-label">Compte</div>
                <a href="{{ route('eleve.profile') }}" class="sidebar-link @active('profile*')">
                    <i class="bi bi-person-circle"></i><span>Mon profil</span>
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-chip mb-2">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}</div>
                <div class="user-info">
                    <div style="font-size:.83rem;font-weight:700;line-height:1.2;color:rgba(255,255,255,.9);">
                        {{ auth()->user()->nom_complet }}
                    </div>
                    <div style="font-size:.74rem;color:rgba(255,255,255,.5);">
                        {{ auth()->user()->telephone }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-left"></i><span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- ══ MAIN ══ --}}
    <div class="main-wrapper" id="mainWrapper">
        <header class="topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm d-lg-none" id="toggleSidebar"
                    style="background:var(--rouge-p);border:none;border-radius:8px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;color:var(--rouge);"
                    aria-label="Ouvrir le menu">
                    <i class="bi bi-list" style="font-size:1.2rem;"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Tableau de bord')</h1>
            </div>
            <div style="font-size:.78rem;color:#ADB5BD;display:flex;align-items:center;gap:.4rem;">
                <i class="bi bi-calendar3" style="color:var(--rouge);"></i>
                {{ now()->isoFormat('ddd D MMM YYYY') }}
            </div>
        </header>

        <main class="main-content">
            @foreach(['success' => 'success', 'warning' => 'warning', 'error' => 'danger', 'info' => 'info'] as $key => $type)
                @if(session($key))
                    <div class="alert alert-{{ $type }} alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-{{ $type === 'success' ? 'check-circle' : 'exclamation-circle' }}-fill me-2"></i>
                        {{ session($key) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif
            @endforeach
            @yield('content')
        </main>
    </div>

    {{-- ══ WHATSAPP ══ --}}
    <a href="https://wa.me/2250545160597?text=Bonjour%2C%20je%20souhaite%20des%20informations%20sur%20la%20formation."
        target="_blank" rel="noopener noreferrer" class="whatsapp-float" aria-label="Support WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        const sidebar = document.getElementById('sidebar'),
            overlay = document.getElementById('sidebarOverlay'),
            toggle = document.getElementById('toggleSidebar');

        if (toggle) {
            const openSidebar = () => { sidebar.classList.add('open'); overlay.classList.add('active'); document.body.style.overflow = 'hidden'; };
            const closeSidebar = () => { sidebar.classList.remove('open'); overlay.classList.remove('active'); document.body.style.overflow = ''; };

            toggle.addEventListener('click', openSidebar);
            overlay.addEventListener('click', closeSidebar);
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeSidebar(); });
            window.addEventListener('resize', function () { if (window.innerWidth > 768) closeSidebar(); }, { passive: true });
        }
    </script>

    @yield('scripts')
</body>

</html>