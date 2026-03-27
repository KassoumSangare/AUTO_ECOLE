@extends('layouts.app')
@section('title', 'Gestion des Catégories de Permis')

@section('content')
<div class="container-fluid py-4">
    
    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1">Catégories de Permis</h2>
            <p class="text-muted mb-0">Gérez les tarifs et les catégories affichés sur le site</p>
        </div>
        <a href="{{ route('admin.permit-categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle catégorie
        </a>
    </div>

    {{-- Messages de succès --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Tableau des catégories --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Code</th>
                            <th class="py-3">Nom</th>
                            <th class="py-3">Description</th>
                            <th class="py-3 text-end">Prix standard</th>
                            <th class="py-3 text-end">Réduction</th>
                            <th class="py-3 text-end">Prix réduit</th>
                            <th class="py-3 text-center">Ordre</th>
                            <th class="py-3 text-center">Statut</th>
                            <th class="py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="badge bg-dark fs-6 fw-bold">{{ $category->code }}</span>
                            </td>
                            <td class="py-3">
                                <strong>{{ $category->name }}</strong>
                            </td>
                            <td class="py-3">
                                <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                            </td>
                            <td class="py-3 text-end">
                                <span class="text-muted text-decoration-line-through">
                                    {{ number_format($category->price, 0, ',', ' ') }} F
                                </span>
                            </td>
                            <td class="py-3 text-end">
                                <span class="badge bg-success">-{{ $category->online_discount_percent }}%</span>
                            </td>
                            <td class="py-3 text-end">
                                <strong class="text-success">{{ number_format($category->discounted_price, 0, ',', ' ') }} F</strong>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge bg-secondary">{{ $category->display_order }}</span>
                            </td>
                            <td class="py-3 text-center">
                                <button 
                                    onclick="toggleActive({{ $category->id }}, this)"
                                    class="btn btn-sm {{ $category->is_active ? 'btn-success' : 'btn-outline-secondary' }}">
                                    <i class="bi {{ $category->is_active ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                    {{ $category->is_active ? 'Actif' : 'Inactif' }}
                                </button>
                            </td>
                            <td class="py-3 text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.permit-categories.edit', $category) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.permit-categories.destroy', $category) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    <p class="mb-0">Aucune catégorie trouvée</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Statistiques --}}
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 opacity-75">Total catégories</h6>
                    <h2 class="card-title mb-0">{{ $categories->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 opacity-75">Catégories actives</h6>
                    <h2 class="card-title mb-0">{{ $categories->where('is_active', true)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 opacity-75">Prix moyen</h6>
                    <h2 class="card-title mb-0">{{ number_format($categories->avg('price'), 0) }} F</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 opacity-75">Réduction moyenne</h6>
                    <h2 class="card-title mb-0">{{ number_format($categories->avg('online_discount_percent'), 1) }}%</h2>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleActive(categoryId, button) {
        fetch(`/admin/permit-categories/${categoryId}/toggle-active`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour le bouton
                const isActive = data.is_active;
                button.className = isActive ? 'btn btn-sm btn-success' : 'btn btn-sm btn-outline-secondary';
                button.innerHTML = `<i class="bi ${isActive ? 'bi-toggle-on' : 'bi-toggle-off'}"></i> ${isActive ? 'Actif' : 'Inactif'}`;
                
                // Afficher une notification
                showToast(isActive ? 'Catégorie activée' : 'Catégorie désactivée');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la modification du statut.');
        });
    }

    function showToast(message) {
        // Si vous utilisez Bootstrap 5 Toast
        const toastHTML = `
            <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        
        // Créer le conteneur de toast s'il n'existe pas
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            document.body.appendChild(container);
        }
        
        container.innerHTML = toastHTML;
        const toastElement = container.querySelector('.toast');
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
</script>
@endpush
@endsection