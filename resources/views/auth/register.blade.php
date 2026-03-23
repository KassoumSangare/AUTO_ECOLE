@extends('layouts.guest')
@section('title', 'Inscription')

@section('head')
<style>
    .auth-section {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, var(--vert-c) 0%, var(--vert) 55%, #1E4D38 100%);
        padding: 2.5rem 0;
        position: relative;
        overflow: hidden;
    }

    .auth-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(90deg,
                transparent 48%, rgba(255, 255, 255, .04) 49%,
                rgba(255, 255, 255, .04) 51%, transparent 52%);
    }

    .auth-section::after {
        content: '';
        position: absolute;
        left: -80px;
        bottom: -80px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
    }

    .auth-card {
        background: var(--fond);
        border-radius: 22px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, .22);
        padding: 2.5rem 2.25rem;
        position: relative;
        z-index: 1;
        animation: card-in .5s cubic-bezier(.4, 0, .2, 1) both;
        border-top: 4px solid var(--vert);
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
        background: linear-gradient(135deg, var(--vert), var(--vert-c));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        box-shadow: 0 8px 24px rgba(45, 106, 79, .4);
    }

    .auth-title {
        font-family: var(--font-d) !important;
        font-weight: 800;
        font-size: 1.55rem;
        color: var(--texte);
        text-align: center;
        margin-bottom: .25rem;
    }

    .auth-sub {
        text-align: center;
        color: var(--texte-2);
        font-size: .88rem;
        margin-bottom: 1.75rem;
    }

    .form-label-a {
        font-weight: 700;
        font-size: .84rem;
        color: var(--texte);
        margin-bottom: .3rem;
        display: block;
    }

    .form-ctrl {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: .65rem 1rem .65rem 2.75rem;
        font-size: .93rem;
        width: 100%;
        background: var(--blanc);
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        font-family: var(--font-b) !important;
    }

    .form-ctrl:focus {
        border-color: var(--vert);
        box-shadow: 0 0 0 3px rgba(45, 106, 79, .12);
    }

    .form-ctrl.err {
        border-color: var(--rouge);
    }

    .icon-group {
        position: relative;
    }

    .icon-group .bi {
        position: absolute;
        left: .9rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--texte-2);
        font-size: .95rem;
        pointer-events: none;
        z-index: 2;
    }

    /* Section separator */
    .sep {
        font-family: var(--font-d) !important;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--texte-2);
        display: flex;
        align-items: center;
        gap: .75rem;
        margin: 1.25rem 0 1rem;
    }

    .sep::before,
    .sep::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .btn-register {
        background: linear-gradient(135deg, var(--vert), var(--vert-c));
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
        box-shadow: 0 4px 16px rgba(45, 106, 79, .3);
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(45, 106, 79, .45);
        color: #fff;
    }

    /* Indicateur force mot de passe */
    .pw-strength {
        height: 4px;
        border-radius: 4px;
        background: var(--border);
        margin-top: .4rem;
        overflow: hidden;
    }

    .pw-strength-bar {
        height: 100%;
        border-radius: 4px;
        width: 0%;
        transition: .3s ease;
    }

    .link-auth {
        color: var(--vert);
        font-weight: 700;
        text-decoration: none;
    }

    .link-auth:hover {
        color: var(--vert-c);
    }

    .err-msg {
        font-size: .81rem;
        color: var(--rouge);
        margin-top: .25rem;
    }

    .opt-tag {
        font-size: .72rem;
        color: var(--texte-2);
        font-weight: 400;
        margin-left: .4rem;
    }
</style>
@endsection

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5">
                <div class="auth-card">

                    <div class="auth-badge">
                        <i class="bi bi-person-plus-fill" style="font-size:1.6rem;color:#fff;"></i>
                    </div>
                    <h1 class="auth-title">Créer mon compte</h1>
                    <p class="auth-sub">Rejoignez Auto-École Le Chemin et démarrez votre formation</p>

                    @if($errors->any())
                    <div class="alert mb-3 py-2 px-3" style="border-radius:10px;font-size:.88rem;background:var(--rouge-p);border:1px solid rgba(175,38,54,.2);color:var(--rouge-c);">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>Veuillez corriger les erreurs ci-dessous.
                    </div>
                    @endif

                    {{-- ⚠️ LOGIQUE PRÉSERVÉE : Champs nom/prenom/telephone/email/password --}}
                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="sep">Identité</div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label-a" for="nom">Nom</label>
                                <div class="icon-group">
                                    <i class="bi bi-person-fill"></i>
                                    <input type="text" id="nom" name="nom"
                                        class="form-ctrl @error('nom') err @enderror"
                                        value="{{ old('nom') }}" placeholder="KONÉ" autocomplete="family-name">
                                </div>
                                @error('nom')<div class="err-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label-a" for="prenom">Prénom</label>
                                <div class="icon-group">
                                    <i class="bi bi-person"></i>
                                    <input type="text" id="prenom" name="prenom"
                                        class="form-ctrl @error('prenom') err @enderror"
                                        value="{{ old('prenom') }}" placeholder="Mamadou" autocomplete="given-name">
                                </div>
                                @error('prenom')<div class="err-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-a" for="telephone">
                                Téléphone <small style="color:var(--texte-2);font-weight:400;">(identifiant unique)</small>
                            </label>
                            <div class="icon-group">
                                <i class="bi bi-phone-fill"></i>
                                <input type="tel" id="telephone" name="telephone"
                                    class="form-ctrl @error('telephone') err @enderror"
                                    value="{{ old('telephone') }}" placeholder="0701234567"
                                    maxlength="10" autocomplete="tel" autofocus>
                            </div>
                            @error('telephone')<div class="err-msg">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label-a" for="email">
                                Email <span class="opt-tag">(optionnel — pour vos reçus)</span>
                            </label>
                            <div class="icon-group">
                                <i class="bi bi-envelope-fill"></i>
                                <input type="email" id="email" name="email"
                                    class="form-ctrl @error('email') err @enderror"
                                    value="{{ old('email') }}" placeholder="exemple@gmail.com" autocomplete="email">
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
                                    placeholder="Minimum 8 caractères"
                                    autocomplete="new-password"
                                    oninput="checkStr(this.value)">
                            </div>
                            @error('password')<div class="err-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="pw-strength mb-3">
                            <div class="pw-strength-bar" id="strBar"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-a" for="password_confirmation">Confirmer le mot de passe</label>
                            <div class="icon-group">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-ctrl" placeholder="••••••••" autocomplete="new-password">
                            </div>
                        </div>

                        <button type="submit" class="btn-register">
                            <i class="bi bi-rocket-takeoff me-2"></i>Créer mon compte
                        </button>
                    </form>

                    <p class="text-center mt-3 mb-0" style="font-size:.88rem;color:var(--texte-2);">
                        Déjà inscrit ?
                        <a href="{{ route('login') }}" class="link-auth ms-1">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
{{-- ⚠️ LOGIQUE PRÉSERVÉE : Indicateur force mot de passe --}}
<script>
    function checkStr(val) {
        let s = 0;
        if (val.length >= 8) s++;
        if (/[A-Z]/.test(val)) s++;
        if (/[0-9]/.test(val)) s++;
        if (/[^A-Za-z0-9]/.test(val)) s++;
        const bar = document.getElementById('strBar');
        const c = ['var(--rouge)', '#CA8A04', 'var(--or)', 'var(--vert)'];
        const w = ['25%', '50%', '75%', '100%'];
        bar.style.width = s > 0 ? w[s - 1] : '0%';
        bar.style.background = s > 0 ? c[s - 1] : '';
    }
</script>
@endsection