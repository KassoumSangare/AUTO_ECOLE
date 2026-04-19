@extends('layouts.guest')
@section('title', 'Inscription')

@section('head')
    <style>
        :root {
            /* Palette de couleurs Expert UI */
            --brand-primary: #3b82f6;
            /* Bleu vif pour les actions */
            --brand-dark: #1e3a8a;
            /* Bleu profond pour le contraste */
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --card-bg: #ffffff;
            --error: #ef4444;
            --success: #10b981;
        }

        .auth-section {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            background: var(--bg-gradient);
            padding: 2.5rem 0;
            position: relative;
            overflow: hidden;
        }

        /* Motif de fond subtil */
        .auth-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.5;
        }

        /* Décoration organique en arrière-plan */
        .auth-section::after {
            content: '';
            position: absolute;
            top: -10%;
            right: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .auth-card {
            background: var(--card-bg);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            padding: 2.5rem 2.25rem;
            position: relative;
            z-index: 1;
            animation: card-in .6s cubic-bezier(.22, 1, .36, 1) both;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes card-in {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-badge {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            transform: rotate(-3deg);
        }

        .auth-title {
            font-family: var(--font-d) !important;
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--text-main);
            text-align: center;
            margin-bottom: .4rem;
        }

        .auth-sub {
            text-align: center;
            color: var(--text-muted);
            font-size: .9rem;
            margin-bottom: 2rem;
            line-height: 1.4;
        }

        .form-label-a {
            font-weight: 600;
            font-size: .85rem;
            color: var(--text-main);
            margin-bottom: .4rem;
            display: block;
        }

        .form-ctrl {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: .75rem 1rem .75rem 2.8rem;
            font-size: .95rem;
            width: 100%;
            background: #f8fafc;
            transition: all .2s ease;
            outline: none;
        }

        .form-ctrl:focus {
            background: #fff;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-ctrl.err {
            border-color: var(--error);
            background: #fffafb;
        }

        .icon-group {
            position: relative;
        }

        .icon-group .bi {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            z-index: 2;
        }

        .sep {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0 1.25rem;
        }

        .sep::before,
        .sep::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-dark));
            border: none;
            color: #fff;
            font-family: var(--font-d) !important;
            font-weight: 700;
            font-size: 1rem;
            padding: .9rem;
            border-radius: 12px;
            width: 100%;
            transition: all .3s ease;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
            margin-top: 1rem;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.4);
            filter: brightness(1.1);
        }

        .pw-strength {
            height: 6px;
            border-radius: 10px;
            background: #e2e8f0;
            margin-top: .6rem;
            overflow: hidden;
        }

        .pw-strength-bar {
            height: 100%;
            width: 0%;
            transition: width .4s ease, background-color .4s ease;
        }

        .link-auth {
            color: var(--brand-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .link-auth:hover {
            text-decoration: underline;
        }

        .err-msg {
            font-size: .8rem;
            color: var(--error);
            margin-top: .3rem;
            font-weight: 500;
        }

        .opt-tag {
            font-size: .75rem;
            color: var(--text-muted);
            font-weight: 400;
        }
    </style>
@endsection

@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                    <div class="auth-card">
                        <div class="auth-badge">
                            <i class="bi bi-person-plus-fill" style="font-size:1.6rem;color:#fff;"></i>
                        </div>
                        <h1 class="auth-title">Création de compte</h1>
                        <p class="auth-sub">Rejoignez l'Auto-École Le Chemin pour une formation d'excellence.</p>

                        @if($errors->any())
                            <div class="alert mb-4 py-2 px-3 d-flex align-items-center"
                                style="border-radius:12px; font-size:.85rem; background:#fef2f2; border:1px solid #fee2e2; color:#b91c1c;">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span>Veuillez corriger les erreurs indiquées.</span>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" novalidate>
                            @csrf

                            <div class="sep">Identité</div>
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label-a" for="nom">Nom</label>
                                    <div class="icon-group">
                                        <i class="bi bi-person-fill"></i>
                                        <input type="text" id="nom" name="nom" class="form-ctrl @error('nom') err @enderror"
                                            value="{{ old('nom') }}" placeholder="KONÉ">
                                    </div>
                                    @error('nom')<div class="err-msg">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label-a" for="prenom">Prénom</label>
                                    <div class="icon-group">
                                        <i class="bi bi-person"></i>
                                        <input type="text" id="prenom" name="prenom"
                                            class="form-ctrl @error('prenom') err @enderror" value="{{ old('prenom') }}"
                                            placeholder="Mamadou">
                                    </div>
                                    @error('prenom')<div class="err-msg">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-a" for="telephone">Téléphone</label>
                                <div class="icon-group">
                                    <i class="bi bi-phone-fill"></i>
                                    <input type="tel" id="telephone" name="telephone"
                                        class="form-ctrl @error('telephone') err @enderror" value="{{ old('telephone') }}"
                                        placeholder="07 00 00 00 00" maxlength="10">
                                </div>
                                @error('telephone')<div class="err-msg">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label-a" for="email">Email <span
                                        class="opt-tag">(optionnel)</span></label>
                                <div class="icon-group">
                                    <i class="bi bi-envelope-fill"></i>
                                    <input type="email" id="email" name="email"
                                        class="form-ctrl @error('email') err @enderror" value="{{ old('email') }}"
                                        placeholder="votre@email.com">
                                </div>
                                @error('email')<div class="err-msg">{{ $message }}</div>@enderror
                            </div>

                            <div class="sep">Sécurité</div>

                            <div class="mb-1">
                                <label class="form-label-a" for="password">Mot de passe</label>
                                <div class="icon-group">
                                    <i class="bi bi-lock-fill"></i>
                                    <input type="password" id="password" name="password"
                                        class="form-ctrl @error('password') err @enderror"
                                        placeholder="8 caractères minimum" oninput="checkStr(this.value)">
                                </div>
                                @error('password')<div class="err-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="pw-strength mb-3">
                                <div class="pw-strength-bar" id="strBar"></div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label-a" for="password_confirmation">Confirmer</label>
                                <div class="icon-group">
                                    <i class="bi bi-shield-check"></i>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-ctrl" placeholder="Confirmez votre mot de passe">
                                </div>
                            </div>

                            <button type="submit" class="btn-register">
                                <i class="bi bi-rocket-takeoff-fill me-2"></i>S'inscrire maintenant
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <span style="font-size:.88rem;color:var(--text-muted);">Déjà un compte ?</span>
                            <a href="{{ route('login') }}" class="link-auth ms-1">Se connecter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function checkStr(val) {
            let s = 0;
            if (val.length >= 8) s++;
            if (/[A-Z]/.test(val)) s++;
            if (/[0-9]/.test(val)) s++;
            if (/[^A-Za-z0-9]/.test(val)) s++;

            const bar = document.getElementById('strBar');
            // Couleurs harmonisées : Rouge -> Orange -> Bleu Indigo -> Vert Succès
            const colors = ['#ef4444', '#f59e0b', '#3b82f6', '#10b981'];
            const widths = ['25%', '50%', '75%', '100%'];

            bar.style.width = s > 0 ? widths[s - 1] : '0%';
            bar.style.backgroundColor = s > 0 ? colors[s - 1] : 'transparent';
        }
    </script>
@endsection