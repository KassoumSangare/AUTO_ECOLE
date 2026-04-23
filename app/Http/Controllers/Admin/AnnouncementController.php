<?php

namespace App\Http\Controllers\Admin;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message'    => 'required|string|max:255',
            'emoji'      => 'nullable|string|max:10',
            'expires_at' => 'required|date|after:now',
            'is_active'  => 'boolean',
        ], [
            'expires_at.after' => 'La date d\'expiration doit être dans le futur.',
        ]);

        Announcement::create([
            'message'    => $validated['message'],
            'emoji'      => $validated['emoji'] ?? '🎉',
            'expires_at' => $validated['expires_at'],
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Annonce créée avec succès.');
    }

    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $request->validate([
            'message'    => 'required|string|max:255',
            'emoji'      => 'nullable|string|max:10',
            'expires_at' => 'required|date',
            'is_active'  => 'boolean',
        ]);

        $announcement->update([
            'message'    => $validated['message'],
            'emoji'      => $validated['emoji'] ?? '🎉',
            'expires_at' => $validated['expires_at'],
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Annonce mise à jour.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();
        return back()->with('success', 'Annonce supprimée.');
    }

    public function toggleActive(Announcement $announcement): RedirectResponse
    {
        $announcement->update(['is_active' => !$announcement->is_active]);
        return back()->with('success', 'Statut mis à jour.');
    }
}