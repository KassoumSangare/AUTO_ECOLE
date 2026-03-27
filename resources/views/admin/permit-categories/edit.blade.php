@extends('layouts.app')
@section('title', 'Modifier Catégorie')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="h3 mb-1">Modifier la catégorie</h2>
        <p class="text-muted">Mettre à jour les informations</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.permit-categories.update', $permitCategory) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Code --}}
                    <div class="col-md-4">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $permitCategory->code) }}" required>
                    </div>

                    {{-- Nom --}}
                    <div class="col-md-8">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $permitCategory->name) }}" required>
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $permitCategory->description) }}</textarea>
                    </div>

                    {{-- Prix --}}
                    <div class="col-md-4">
                        <label class="form-label">Prix (FCFA)</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $permitCategory->price) }}" required>
                    </div>

                    {{-- Réduction --}}
                    <div class="col-md-4">
                        <label class="form-label">Réduction (%)</label>
                        <input type="number" step="0.01" name="online_discount_percent" class="form-control" value="{{ old('online_discount_percent', $permitCategory->online_discount_percent) }}">
                    </div>

                    {{-- Ordre --}}
                    <div class="col-md-4">
                        <label class="form-label">Ordre d'affichage</label>
                        <input type="number" name="display_order" class="form-control" value="{{ old('display_order', $permitCategory->display_order) }}">
                    </div>

                    {{-- Statut --}}
                    <div class="col-12">
                        <div class="form-check form-switch mt-2">
                            <input type="checkbox" name="is_active" class="form-check-input"
                                   {{ old('is_active', $permitCategory->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label">Activer cette catégorie</label>
                        </div>
                    </div>

                </div>

                {{-- Aperçu prix réduit --}}
                <div class="alert mt-4" style="background: var(--or-p); border-left: 4px solid var(--or);">
                    <strong>Prix actuel :</strong>
                    {{ number_format($permitCategory->price, 0, ',', ' ') }} F → 
                    <strong class="text-success">
                        {{ number_format($permitCategory->discounted_price, 0, ',', ' ') }} F
                    </strong>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.permit-categories.index') }}" class="btn btn-outline-secondary">
                        Retour
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Mettre à jour
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection