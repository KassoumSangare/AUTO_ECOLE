<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermitCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermitCategoryController extends Controller
{
    /**
     * Affiche la liste des catégories.
     */
    public function index()
    {
        $categories = PermitCategory::ordered()->get();
        return view('admin.permit-categories.index', compact('categories'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('admin.permit-categories.create');
    }

    /**
     * Enregistre une nouvelle catégorie.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:permit_categories,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'online_discount_percent' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'display_order' => 'required|integer|min:0',
        ]);

        PermitCategory::create($validated);

        return redirect()
            ->route('admin.permit-categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(PermitCategory $permitCategory)
    {
        return view('admin.permit-categories.edit', compact('permitCategory'));
    }

    /**
     * Met à jour une catégorie.
     */

public function update(Request $request, PermitCategory $permitCategory)
{
    $validated = $request->validate([
        'code' => [
            'required',
            'string',
            'max:20',
            Rule::unique('permit_categories', 'code')->ignore($permitCategory->id),
        ],
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'online_discount_percent' => 'required|numeric|min:0|max:100',
        'display_order' => 'required|integer|min:0',
    ]);

    // ✅ Gestion correcte du checkbox
    $validated['is_active'] = $request->has('is_active');

    $permitCategory->update($validated);

    return redirect()
        ->route('admin.permit-categories.index')
        ->with('success', 'Catégorie mise à jour avec succès.');
}

    /**
     * Supprime une catégorie.
     */
    public function destroy(PermitCategory $permitCategory)
    {
        $permitCategory->delete();

        return redirect()
            ->route('admin.permit-categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    /**
     * Active/désactive une catégorie (via AJAX).
     */
    public function toggleActive(PermitCategory $permitCategory)
    {
        $permitCategory->update([
            'is_active' => !$permitCategory->is_active,
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $permitCategory->is_active,
        ]);
    }
}
