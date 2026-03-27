@extends('layouts.app')
@section('title', 'Nouvelle Catégorie')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="h3 mb-1">Ajouter une catégorie</h2>
        <p class="text-muted">Créer une nouvelle catégorie de permis</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.permit-categories.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Code --}}
                    <div class="col-md-4">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                    </div>

                    {{-- Nom --}}
                    <div class="col-md-8">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                    {{-- Prix --}}
                    <div class="col-md-4">
                        <label class="form-label">Prix (FCFA)</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                    </div>

                    {{-- Réduction --}}
                    <div class="col-md-4">
                        <label class="form-label">Réduction (%)</label>
                        <input type="number" step="0.01" name="online_discount_percent" class="form-control" value="{{ old('online_discount_percent', 0) }}">
                    </div>

                    {{-- Ordre --}}
                    <div class="col-md-4">
                        <label class="form-label">Ordre d'affichage</label>
                        <input type="number" name="display_order" class="form-control" value="{{ old('display_order', 0) }}">
                    </div>

                    {{-- Statut --}}
                    <div class="col-12">
                        <div class="form-check form-switch mt-2">
                            <input type="checkbox" name="is_active" class="form-check-input" checked>
                            <label class="form-check-label">Activer cette catégorie</label>
                        </div>
                    </div>

                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.permit-categories.index') }}" class="btn btn-outline-secondary">
                        Retour
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Enregistrer
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection