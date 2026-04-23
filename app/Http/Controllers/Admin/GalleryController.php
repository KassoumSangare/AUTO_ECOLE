<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(): View
    {
        $photos = Gallery::orderBy('order')->orderByDesc('created_at')->paginate(20);
        return view('admin.gallery.index', compact('photos'));
    }

    public function create(): View
    {
        $categories = Gallery::categoryLabels();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'category' => 'required|in:seance,moniteur,voiture,autre',
            'image' => 'required|file|mimes:jpg,jpeg,png,webp|max:4096',
            'order' => 'nullable|integer|min:0',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'image_path' => $path,
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Photo ajoutée avec succès.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return back()->with('success', 'Photo supprimée.');
    }

    public function toggleActive(Gallery $gallery): RedirectResponse
    {
        $gallery->update(['is_active' => !$gallery->is_active]);
        return back()->with('success', 'Statut mis à jour.');
    }
}