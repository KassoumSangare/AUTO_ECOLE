<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#C8102E">
    <meta name="description" content="@yield('meta_description', 'Auto-École Le Chemin à Abidjan : formation complète au permis de conduire.')">
    <meta name="robots" content="index, follow">
    <title>@yield('title', 'Auto-École Le Chemin') — Permis de conduire à Abidjan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    {{-- Font override AVANT Bootstrap --}}
    <style>
        html,
        body,
        input,
        button,
        select,
        textarea {
            font-family: 'DM Sans', 'Helvetica Neue', Arial, sans-serif !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Syne', Georgia, serif !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        /* ══ PALETTE Le Chemin — Rouge · Vert · Blanc ══════════ */
        :root {
            --rouge: #C8102E;
            --rouge-c: #A00D24;
            --rouge-p: #FDF2F4;
            --vert: #009A44;
            --vert-c: #007A36;
            --vert-p: #F0FAF4;
            --blanc: #FFFFFF;
            --fond: #FAFAF8;
            --texte: #111827;
            --texte-2: #6B7280;
            --or: #D4A843;
            /* conservé pour accents hero/or */
            --or-c: #F0C060;
            --font-d: 'Syne', Georgia, serif;
            --font-b: 'DM Sans', 'Helvetica Neue', Arial, sans-serif;
            --trans: .28s cubic-bezier(.4, 0, .2, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-b) !important;
            background: var(--fond);
            color: var(--texte);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ══ NAVBAR ══════════════════════════════════════════════ */
        .navbar-lc {
            background: var(--rouge);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0, 0, 0, .25);
            transition: padding .3s ease, box-shadow .3s ease;
        }

        .navbar-lc.scrolled {
            box-shadow: 0 4px 30px rgba(0, 0, 0, .35);
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .85rem 1rem;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            text-decoration: none;
        }

        .nav-brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #fff;
            color: var(--rouge);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-d) !important;
            font-weight: 900;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .nav-brand-text {
            font-family: var(--font-d) !important;
            font-weight: 800;
            font-size: 1.2rem;
            color: #fff;
            white-space: nowrap;
        }

        .nav-brand-text span {
            color: var(--vert-p);
        }

        .nav-link-item {
            color: rgba(255, 255, 255, .88);
            text-decoration: none;
            font-size: .88rem;
            font-weight: 500;
            padding: .4rem .85rem;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            transition: background .2s ease, color .2s ease;
        }

        .nav-link-item:hover {
            background: rgba(255, 255, 255, .15);
            color: #fff;
        }

        .nav-link-register {
            background: #fff;
            color: var(--rouge) !important;
            font-family: var(--font-d) !important;
            font-weight: 800;
            padding: .42rem 1.1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: .88rem;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            transition: background .2s ease, color .2s ease;
        }

        .nav-link-register:hover {
            background: var(--vert-p);
            color: var(--vert) !important;
        }

        .burger-btn {
            background: rgba(255, 255, 255, .15);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 1.3rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s;
        }

        .burger-btn:hover {
            background: rgba(255, 255, 255, .25);
        }

        .mobile-menu {
            display: none;
            background: var(--rouge-c);
            border-top: 1px solid rgba(255, 255, 255, .1);
            padding: .75rem 1rem 1rem;
        }

        .mobile-menu.open {
            display: block;
            animation: fadeDown .2s ease both;
        }

        .mobile-menu-link {
            display: flex;
            align-items: center;
            gap: .55rem;
            color: rgba(255, 255, 255, .9);
            text-decoration: none;
            padding: .65rem .75rem;
            border-radius: 8px;
            font-size: .9rem;
            margin-bottom: .2rem;
            transition: background .2s;
        }

        .mobile-menu-link:hover {
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }

        .mobile-menu-link i {
            color: rgba(255, 255, 255, .7);
            font-size: 1rem;
            width: 18px;
            text-align: center;
        }

        /* ══ FOOTER ══════════════════════════════════════════════ */
        .site-footer {
            background: var(--rouge-c);
            color: rgba(255, 255, 255, .65);
            font-size: .83rem;
            padding: 1.75rem 0;
            border-top: 3px solid var(--vert);
        }

        .site-footer strong {
            color: #fff;
            font-family: var(--font-d) !important;
        }

        .site-footer .footer-brand {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-family: var(--font-d) !important;
            font-weight: 800;
            font-size: 1rem;
            color: #fff;
        }

        .site-footer .footer-brand .dot-vert {
            color: var(--vert-p);
        }

        /* ══ WHATSAPP ════════════════════════════════════════════ */
        .whatsapp-float {
            position: fixed;
            bottom: 28px;
            right: 28px;
            width: 60px;
            height: 60px;
            background: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(37, 211, 102, .45);
            animation: wa-pulse 2.2s ease-out infinite;
            transition: transform .25s ease;
        }

        .whatsapp-float:hover {
            transform: scale(1.14) translateY(-3px);
            animation-play-state: paused;
            box-shadow: 0 8px 32px rgba(37, 211, 102, .65);
        }

        .whatsapp-float i {
            font-size: 1.85rem;
            color: #fff;
        }

        .whatsapp-float::before {
            content: 'Nous contacter';
            position: absolute;
            right: 70px;
            background: var(--rouge-c);
            color: #fff;
            font-size: .76rem;
            font-weight: 600;
            padding: .35rem .8rem;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            transform: translateX(6px);
            transition: opacity .25s, transform .25s;
            pointer-events: none;
        }

        .whatsapp-float:hover::before {
            opacity: 1;
            transform: translateX(0);
        }

        #backToTop {
            position: fixed;
            bottom: 100px;
            right: 28px;
            width: 42px;
            height: 42px;
            background: var(--rouge);
            color: #fff;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 998;
            opacity: 0;
            transform: translateY(12px);
            transition: .3s ease;
            box-shadow: 0 4px 16px rgba(200, 16, 46, .35);
            cursor: pointer;
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-10px)
            }

            to {
                opacity: 1;
                transform: none
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

        @keyframes road-scroll {
            from {
                background-position: 0 0
            }

            to {
                background-position: 0 200px
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

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(28px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeLeft {
            from {
                opacity: 0;
                transform: translateX(28px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .65s cubic-bezier(.4, 0, .2, 1), transform .65s cubic-bezier(.4, 0, .2, 1);
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

        .anim-fade-up {
            animation: fadeUp .6s cubic-bezier(.4, 0, .2, 1) both;
        }

        .anim-fade-down {
            animation: fadeDown .5s ease both;
        }

        .anim-fade-left {
            animation: fadeLeft .6s cubic-bezier(.4, 0, .2, 1) both;
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

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #F0F4FA;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 3px;
        }

        :focus-visible {
            outline: 2px solid var(--rouge);
            outline-offset: 3px;
            border-radius: 4px;
        }

        @media (max-width:575px) {
            .whatsapp-float {
                width: 52px;
                height: 52px;
                bottom: 16px;
                right: 16px;
            }

            .whatsapp-float i {
                font-size: 1.55rem;
            }

            .whatsapp-float::before {
                display: none;
            }

            #backToTop {
                right: 16px;
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
            }

            .reveal {
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>

    @yield('head')
</head>

<body>

    {{-- ══ NAVBAR ══ --}}
    <nav class="navbar-lc" id="navbar" role="navigation" aria-label="Navigation principale">
        <div class="container navbar-inner">
            <a href="{{ route('home') }}" class="nav-brand">
                <div class="nav-brand-icon">LC</div>
                <span class="nav-brand-text">Le&nbsp;<span>Chemin</span></span>
            </a>

            <div class="d-none d-md-flex align-items-center gap-1">
                <a href="{{ route('home') }}" class="nav-link-item"><i class="bi bi-house"></i>Accueil</a>
                <a href="#features" class="nav-link-item"><i class="bi bi-grid"></i>Services</a>
                <a href="#contact" class="nav-link-item"><i class="bi bi-geo-alt"></i>Contact</a>
                @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('eleve.dashboard') }}" class="nav-link-item">
                    <i class="bi bi-person-circle"></i>Mon espace
                </a>
                @else
                <a href="{{ route('login') }}" class="nav-link-item"><i class="bi bi-box-arrow-in-right"></i>Connexion</a>
                <a href="{{ route('register') }}" class="nav-link-register ms-1"><i class="bi bi-person-plus-fill"></i>S'inscrire</a>
                @endauth
            </div>

            <button class="burger-btn d-md-none" id="burgerBtn" aria-label="Menu" aria-expanded="false">
                <i class="bi bi-list" id="burgerIcon"></i>
            </button>
        </div>

        <div class="mobile-menu" id="mobileMenu">
            <div class="container">
                <a href="{{ route('home') }}" class="mobile-menu-link"><i class="bi bi-house-fill"></i>Accueil</a>
                <a href="#features" class="mobile-menu-link"><i class="bi bi-grid-fill"></i>Services</a>
                <a href="#contact" class="mobile-menu-link"><i class="bi bi-geo-alt-fill"></i>Contact</a>
                @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('eleve.dashboard') }}" class="mobile-menu-link">
                    <i class="bi bi-person-circle"></i>Mon espace
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:.25rem;">
                    @csrf
                    <button type="submit" class="mobile-menu-link w-100 text-start" style="background:rgba(0,0,0,.15);border:none;cursor:pointer;">
                        <i class="bi bi-box-arrow-left"></i>Déconnexion
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="mobile-menu-link"><i class="bi bi-box-arrow-in-right"></i>Connexion</a>
                <a href="{{ route('register') }}" style="background:#fff;color:var(--rouge);font-weight:800;border-radius:8px;padding:.65rem .75rem;display:flex;align-items:center;gap:.5rem;font-size:.9rem;text-decoration:none;margin-top:.3rem;">
                    <i class="bi bi-person-plus-fill"></i>S'inscrire gratuitement
                </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ══ CONTENU ══ --}}
    <main>@yield('content')</main>

    {{-- ══ FOOTER ══ --}}
    <footer class="site-footer">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <div class="footer-brand">
                        <div style="width:30px;height:30px;border-radius:8px;background:var(--rouge);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:900;color:#fff;">LC</div>
                        <span>Le <span class="dot-vert">Chemin</span></span>
                    </div>
                    <div class="mt-1" style="font-size:.8rem;">
                        Abidjan, Côte d'Ivoire &nbsp;·&nbsp; &copy; {{ date('Y') }} Tous droits réservés.
                    </div>
                </div>
                <div class="col-md-6 text-md-end d-flex flex-wrap gap-3 justify-content-md-end align-items-center">
                    <a href="tel:+2252724318838" style="color:rgba(255,255,255,.6);text-decoration:none;font-size:.82rem;display:flex;align-items:center;gap:.35rem;">
                        <i class="bi bi-telephone-fill" style="color:var(--vert-p);"></i>+225 27 24 31 88 38
                    </a>
                    <a href="https://wa.me/2252724318838" target="_blank" style="color:rgba(255,255,255,.6);text-decoration:none;font-size:.82rem;display:flex;align-items:center;gap:.35rem;">
                        <i class="bi bi-whatsapp" style="color:#25D366;"></i>WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ══ WHATSAPP ══ --}}
    <a href="https://wa.me/2252724318838?text=Bonjour%2C%20je%20souhaite%20m'inscrire%20%C3%A0%20l'auto-%C3%A9cole%20Le%20Chemin."
        target="_blank" rel="noopener noreferrer" class="whatsapp-float" aria-label="Nous contacter sur WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    {{-- ══ BACK TO TOP ══ --}}
    <button id="backToTop" aria-label="Retour en haut"><i class="bi bi-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const burgerBtn = document.getElementById('burgerBtn'),
            mobileMenu = document.getElementById('mobileMenu'),
            burgerIcon = document.getElementById('burgerIcon');
        burgerBtn.addEventListener('click', function() {
            const o = mobileMenu.classList.toggle('open');
            burgerIcon.className = o ? 'bi bi-x-lg' : 'bi bi-list';
            burgerBtn.setAttribute('aria-expanded', o);
        });
        document.addEventListener('click', function(e) {
            if (!burgerBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.remove('open');
                burgerIcon.className = 'bi bi-list';
            }
        });
        window.addEventListener('scroll', function() {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
        }, {
            passive: true
        });
        window.addEventListener('scroll', function() {
            const b = document.getElementById('backToTop'),
                s = window.scrollY > 400;
            b.style.opacity = s ? '1' : '0';
            b.style.transform = s ? 'translateY(0)' : 'translateY(12px)';
        }, {
            passive: true
        });
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        const revObs = new IntersectionObserver(function(e) {
            e.forEach(function(x) {
                if (x.isIntersecting) {
                    x.target.classList.add('visible');
                    revObs.unobserve(x.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });
        document.querySelectorAll('.reveal,.stagger').forEach(function(el) {
            revObs.observe(el);
        });
        const vc = document.getElementById('viewCount');
        if (vc) {
            const t = parseInt(vc.dataset.target, 10),
                ease = function(x) {
                    return 1 - Math.pow(1 - x, 3)
                };
            setTimeout(function() {
                const s = performance.now();
                (function tick(n) {
                    const p = Math.min((n - s) / 2000, 1);
                    vc.textContent = Math.round(t * ease(p)).toLocaleString('fr-FR');
                    if (p < 1) requestAnimationFrame(tick);
                })(performance.now());
            }, 500);
        }
        const cObs = new IntersectionObserver(function(e) {
            e.forEach(function(x) {
                if (!x.isIntersecting) return;
                const el = x.target,
                    t = parseInt(el.dataset.counter, 10);
                if (isNaN(t)) return;
                const s = performance.now(),
                    ease = function(v) {
                        return 1 - Math.pow(1 - v, 3)
                    };
                (function tick(n) {
                    const p = Math.min((n - s) / 1400, 1);
                    el.textContent = Math.round(t * ease(p));
                    if (p < 1) requestAnimationFrame(tick);
                })(s);
                cObs.unobserve(el);
            });
        }, {
            threshold: .4
        });
        document.querySelectorAll('[data-counter]').forEach(function(el) {
            cObs.observe(el);
        });
    </script>
    @yield('scripts')
</body>

</html>