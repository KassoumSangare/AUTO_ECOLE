@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- En-tête de page --}}
            <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="bi bi-person-circle me-2"></i>
                        Mon Profil
                    </h1>
                    <p class="text-muted mb-0">Gérez vos informations personnelles et votre sécurité</p>
                </div>
            </div>

            {{-- Messages Flash --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show slide-down" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show slide-down" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4">
                
                {{-- Carte Informations Personnelles --}}
                <div class="col-lg-6">
                    <div class="card card-hover shadow-sm border-0 h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-person-badge me-2"></i>
                                Informations Personnelles
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- Nom --}}
                                <div class="mb-3">
                                    <label for="nom" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1"></i>
                                        Nom <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control form-control-lg @error('nom') is-invalid @enderror" 
                                        id="nom" 
                                        name="nom" 
                                        value="{{ old('nom', $user->nom) }}" 
                                        required
                                        placeholder="Votre nom"
                                    >
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Prénom --}}
                                <div class="mb-3">
                                    <label for="prenom" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1"></i>
                                        Prénom <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control form-control-lg @error('prenom') is-invalid @enderror" 
                                        id="prenom" 
                                        name="prenom" 
                                        value="{{ old('prenom', $user->prenom) }}" 
                                        required
                                        placeholder="Votre prénom"
                                    >
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-1"></i>
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="email" 
                                        class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email', $user->email) }}" 
                                        required
                                        placeholder="votre@email.com"
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Téléphone --}}
                                <div class="mb-4">
                                    <label for="telephone" class="form-label fw-semibold">
                                        <i class="bi bi-phone me-1"></i>
                                        Téléphone <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="tel" 
                                        class="form-control form-control-lg @error('telephone') is-invalid @enderror" 
                                        id="telephone" 
                                        name="telephone" 
                                        value="{{ old('telephone', $user->telephone) }}" 
                                        required
                                        placeholder="+225 XX XX XX XX XX"
                                    >
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Bouton Enregistrer --}}
                                <button type="submit" class="btn btn-primary btn-lg w-100 btn-pulse">
                                    <i class="bi bi-save me-2"></i>
                                    Enregistrer les modifications
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Carte Sécurité (Mot de passe) --}}
                <div class="col-lg-6">
                    <div class="card card-hover shadow-sm border-0 h-100">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-shield-lock me-2"></i>
                                Sécurité du Compte
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.updatePassword') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="alert alert-info border-0 mb-4">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <small>
                                        Le mot de passe doit contenir au minimum 8 caractères avec des lettres majuscules, 
                                        minuscules, des chiffres et des symboles.
                                    </small>
                                </div>

                                {{-- Mot de passe actuel --}}
                                <div class="mb-3">
                                    <label for="current_password" class="form-label fw-semibold">
                                        <i class="bi bi-key me-1"></i>
                                        Mot de passe actuel <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input 
                                            type="password" 
                                            class="form-control form-control-lg @error('current_password') is-invalid @enderror" 
                                            id="current_password" 
                                            name="current_password" 
                                            required
                                            placeholder="••••••••"
                                        >
                                        <button 
                                            class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('current_password')"
                                        >
                                            <i class="bi bi-eye" id="icon-current_password"></i>
                                        </button>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Nouveau mot de passe --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="bi bi-key-fill me-1"></i>
                                        Nouveau mot de passe <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input 
                                            type="password" 
                                            class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                            id="password" 
                                            name="password" 
                                            required
                                            placeholder="••••••••"
                                        >
                                        <button 
                                            class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('password')"
                                        >
                                            <i class="bi bi-eye" id="icon-password"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Confirmation nouveau mot de passe --}}
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="bi bi-check2-square me-1"></i>
                                        Confirmer le nouveau mot de passe <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input 
                                            type="password" 
                                            class="form-control form-control-lg" 
                                            id="password_confirmation" 
                                            name="password_confirmation" 
                                            required
                                            placeholder="••••••••"
                                        >
                                        <button 
                                            class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('password_confirmation')"
                                        >
                                            <i class="bi bi-eye" id="icon-password_confirmation"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Bouton Changer --}}
                                <button type="submit" class="btn btn-danger btn-lg w-100 btn-pulse">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Changer le mot de passe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Carte Informations Compte --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-hover shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Informations du Compte
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-circle bg-primary text-white">
                                                <i class="bi bi-person-check-fill"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-muted mb-0 small">Rôle</p>
                                            <p class="mb-0 fw-semibold">
                                                <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-circle bg-success text-white">
                                                <i class="bi bi-calendar-check"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-muted mb-0 small">Membre depuis</p>
                                            <p class="mb-0 fw-semibold">{{ $user->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-circle bg-warning text-white">
                                                <i class="bi bi-clock-history"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-muted mb-0 small">Dernière modification</p>
                                            <p class="mb-0 fw-semibold">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Styles CSS personnalisés --}}
<style>
    /* Animations au chargement */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.02);
        }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .slide-down {
        animation: slideDown 0.4s ease-out;
    }

    /* Effet hover sur les cartes */
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        border-color: rgba(13, 110, 253, 0.3);
    }

    /* Boutons avec effet pulse */
    .btn-pulse {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-pulse:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-pulse:active {
        transform: scale(0.98);
        animation: pulse 0.3s ease-in-out;
    }

    /* Avatar circulaire pour les infos */
    .avatar-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Amélioration des inputs */
    .form-control:focus,
    .input-group .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .form-control-lg {
        border-radius: 8px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .form-control-lg:hover {
        border-color: #adb5bd;
    }

    /* En-têtes de cartes avec gradient subtil */
    .card-header {
        border-bottom: 2px solid rgba(255, 255, 255, 0.3);
        font-weight: 500;
    }

    /* Labels avec style amélioré */
    .form-label {
        color: #495057;
        margin-bottom: 8px;
    }

    /* Améliorations responsives */
    @media (max-width: 768px) {
        .card-hover:hover {
            transform: none;
        }

        .btn-pulse:hover {
            transform: none;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
</style>

{{-- JavaScript pour toggle password --}}
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById('icon-' + fieldId);
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Auto-dismiss des alertes après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
@endsection