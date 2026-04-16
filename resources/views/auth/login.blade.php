@extends('layouts.guest')
@section('title', 'Connexion')

@section('head')
<style>
    /* ── Auth shared (login) ─────────────────────────── */
    .auth-section {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, var(--rouge-c) 0%, var(--rouge) 55%, #6B1520 100%);
        padding: 2rem 0;
        position: relative;
        overflow: hidden;
    }

    .auth-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(90deg,
                transparent, transparent 48%,
                rgba(255, 255, 255, .04) 49%, rgba(255, 255, 255, .04) 51%,
                transparent 52%);
        animation: road-scroll 8s linear infinite;
    }

    .auth-section::after {
        content: '';
        position: absolute;
        right: -100px;
        top: -100px;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .04);
    }

    @keyframes road-scroll {
        from {
            background-position: 0 0
        }

        to {
            background-position: 0 120px
        }
    }

    .auth-card {
        background: var(--fond);
        border-radius: 22px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, .22);
        padding: 2.5rem 2.25rem;
        position: relative;
        z-index: 1;
        animation: card-in .5s cubic-bezier(.4, 0, .2, 1) both;
        border-top: 4px solid var(--rouge);
    }

    @keyframes card-in {
        from {
            opacity: 0;
            transform: translateY(28px)
        }

        to {
            opacity: 1;
            transform: none
        }
    }

    .auth-badge {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--rouge), var(--rouge-c));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        box-shadow: 0 8px 24px rgba(175, 38, 54, .35);
    }

    .auth-title {
        font-family: var(--font-d) !important;
        font-weight: 800;
        font-size: 1.6rem;
        color: var(--texte);
        text-align: center;
        margin-bottom: .25rem;
    }

    .auth-sub {
        text-align: center;
        color: var(--texte-2);
        font-size: .9rem;
        margin-bottom: 2rem;
    }

    /* Form controls */
    .form-label-a {
        font-weight: 700;
        font-size: .84rem;
        color: var(--texte);
        margin-bottom: .35rem;
        display: block;
    }

    .form-ctrl {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        /* Padding modifié : 2.75rem à droite pour laisser la place à l'œil */
        padding: .7rem 2.75rem .7rem 2.75rem;
        font-size: .93rem;
        width: 100%;
        background: var(--blanc);
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        font-family: var(--font-b) !important;
    }

    .form-ctrl:focus {
        border-color: var(--rouge);
        box-shadow: 0 0 0 3px rgba(175, 38, 54, .12);
    }

    .form-ctrl.err {
        border-color: var(--rouge);
    }

    .icon-group {
        position: relative;
    }

    .icon-group>.bi:not(.bi-eye-fill):not(.bi-eye-slash-fill) {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--texte-2);
        font-size: 1rem;
        pointer-events: none;
    }

    /* Nouveau style pour le bouton d'affichage du mot de passe */
    .btn-toggle-password {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--texte-2);
        padding: 0.5rem;
        cursor: pointer;
        outline: none;
        transition: color 0.2s;
    }

    .btn-toggle-password:hover,
    .btn-toggle-password:focus {
        color: var(--rouge);
    }

    .btn-login {
        background: linear-gradient(135deg, var(--rouge), var(--rouge-c));
        border: none;
        color: #fff;
        font-family: var(--font-d) !important;
        font-weight: 800;
        font-size: 1rem;
        padding: .8rem;
        border-radius: 10px;
        width: 100%;
        transition: var(--trans);
        letter-spacing: .02em;
        box-shadow: 0 4px 16px rgba(175, 38, 54, .3);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(175, 38, 54, .45);
        color: #fff;
    }

    .divider {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin: 1.5rem 0;
        color: var(--texte-2);
        font-size: .82rem;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .link-auth {
        color: var(--rouge);
        font-weight: 700;
        text-decoration: none;
    }

    .link-auth:hover {
        color: var(--rouge-c);
        text-decoration: underline;
    }

    .err-msg {
        font-size: .82rem;
        color: var(--rouge);
        margin-top: .25rem;
    }

    /* Remember me */
    .form-check-input:checked {
        background-color: var(--rouge);
        border-color: var(--rouge);
    }
</style>
@endsection

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                <div class="auth-card">

                    <div class="auth-badge">
                        <i class="bi bi-shield-lock-fill" style="font-size:1.6rem;color:#fff;"></i>
                    </div>
                    <h1 class="auth-title">Connexion</h1>
                    <p class="auth-sub">Accédez à votre espace de formation</p>

                    @if($errors->any())
                    <div class="alert mb-3 py-2 px-3" style="border-radius:10px;font-size:.88rem;background:var(--rouge-p);border:1px solid rgba(175,38,54,.2);color:var(--rouge-c);">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
                    </div>
                    @endif

                    {{-- ⚠️ LOGIQUE PRÉSERVÉE : Auth par téléphone --}}
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-a" for="telephone">Numéro de téléphone</label>
                            <div class="icon-group">
                                <i class="bi bi-phone-fill"></i>
                                <input type="tel" id="telephone" name="telephone"
                                    class="form-ctrl @error('telephone') err @enderror"
                                    value="{{ old('telephone') }}" placeholder="0701234567"
                                    maxlength="10" autocomplete="username" autofocus>
                            </div>
                            @error('telephone')<div class="err-msg">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label-a" for="password">Mot de passe</label>
                            <div class="icon-group">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" id="password" name="password"
                                    class="form-ctrl @error('password') err @enderror"
                                    placeholder="••••••••" autocomplete="current-password">

                                {{-- Bouton d'affichage du mot de passe ajouté ici --}}
                                <button type="button" class="btn-toggle-password" id="togglePassword" tabindex="-1" aria-label="Afficher le mot de passe">
                                    <i class="bi bi-eye-fill" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')<div class="err-msg">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember" style="font-size:.88rem;color:var(--texte-2);">Se souvenir de moi</label>
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>
                    </form>

                    <div class="divider">Pas encore de compte ?</div>
                    <div class="text-center">
                        <a href="{{ route('register') }}" class="link-auth">
                            <i class="bi bi-person-plus me-1"></i>Créer mon compte gratuitement
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Script pour gérer l'affichage du mot de passe --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function() {
            // Bascule le type de l'input (password <-> text)
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Bascule l'icône (œil ouvert <-> œil barré)
            toggleIcon.classList.toggle('bi-eye-fill');
            toggleIcon.classList.toggle('bi-eye-slash-fill');

            // Ajustement de l'accessibilité
            if (type === 'text') {
                togglePassword.setAttribute('aria-label', 'Masquer le mot de passe');
            } else {
                togglePassword.setAttribute('aria-label', 'Afficher le mot de passe');
            }
        });
    });
</script>
@endsection