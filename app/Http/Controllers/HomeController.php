<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\PageView;
use App\Models\PermitCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec les catégories et le compteur de vues.
     */
    public function index(): View
    {
        // Récupérer les catégories actives triées par ordre d'affichage
        $categories = PermitCategory::active()->ordered()->get();

        // Remplacement de la valeur statique (12547) par la logique réelle.
        // Option A : Si chaque visite = une nouvelle ligne dans la table
        $totalVues = PageView::hit('home');

        // Option B : Si vous avez une ligne unique avec une colonne "views" que vous incrémentez
        // $totalVues = PageView::sum('views');

        $galleryPhotos = Gallery::where('is_active', true)
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->get();
        $announcement = Announcement::visible()->latest()->first();

        return view('welcome', compact('categories', 'totalVues', 'galleryPhotos', 'announcement'));
    }

    /**
     * API pour récupérer les détails d'une catégorie (pour le JS).
     */
    public function getCategory(string $code): JsonResponse
    {
        $category = PermitCategory::where('code', $code)->active()->first();

        if (!$category) {
            return response()->json(['error' => 'Catégorie non trouvée'], 404);
        }

        return response()->json([
            'code' => $category->code,
            'name' => $category->name,
            'description' => $category->description,
            'price' => $category->price,
            'discounted_price' => $category->discounted_price,
            'discount_percent' => $category->online_discount_percent, // Note: vérifier la cohérence du nom si c'est online_discount_percent
            'discount_amount' => $category->discount_amount,
            'formatted_price' => $category->formatted_price,
            'formatted_discounted_price' => $category->formatted_discounted_price,
        ]);
    }
}