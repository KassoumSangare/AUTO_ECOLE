<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DocumentController extends Controller
{
    /**
     * Extensions autorisées par type de document.
     */
    private const ALLOWED_MIMES = ['pdf', 'jpg', 'jpeg', 'png'];
    private const MAX_SIZE_KB   = 5120; // 5 Mo

    // ──────────────────────────────────────────
    // LISTE DES DOCUMENTS DE L'ÉLÈVE
    // ──────────────────────────────────────────

    public function index(): View
    {
        $user      = Auth::user();
        $documents = $user->documents()->latest()->get();

        // Regrouper par type pour l'affichage
        $parType = $documents->groupBy('type');

        // Quels types manquent encore ?
        $typesRequis    = Document::TYPES;
        $typesDéposes   = $documents->pluck('type')->unique()->toArray();
        $typesManquants = array_diff($typesRequis, $typesDéposes);

        return view('eleve.documents', compact('documents', 'parType', 'typesManquants'));
    }

    // ──────────────────────────────────────────
    // UPLOAD D'UN DOCUMENT
    // ──────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        // 1. Validation stricte
        $request->validate([
            'type'   => ['required', 'in:' . implode(',', Document::TYPES)],
            'fichier'=> [
                'required',
                'file',
                'mimes:' . implode(',', self::ALLOWED_MIMES),
                'max:' . self::MAX_SIZE_KB,
            ],
        ], [
            'type.required'    => 'Veuillez sélectionner le type de document.',
            'type.in'          => 'Type de document invalide.',
            'fichier.required' => 'Veuillez sélectionner un fichier.',
            'fichier.file'     => 'Le fichier est invalide.',
            'fichier.mimes'    => 'Format non accepté. Formats autorisés : PDF, JPG, PNG.',
            'fichier.max'      => 'Le fichier ne doit pas dépasser 5 Mo.',
        ]);

        $user = Auth::user();

        // 2. Vérifier si un document du même type est déjà en attente ou validé
        $existant = $user->documents()
                         ->where('type', $request->type)
                         ->whereIn('status', ['en_attente', 'valide'])
                         ->first();

        if ($existant) {
            return back()->withErrors([
                'fichier' => "Vous avez déjà déposé un document de type « {$existant->label_type} » ({$existant->status}). Supprimez-le avant d'en soumettre un nouveau."
            ]);
        }

        // 3. Stocker le fichier dans storage/app/private/documents/{user_id}/
        $fichier = $request->file('fichier');
        $path    = $fichier->store("documents/{$user->id}", 'private');

        // 4. Créer l'entrée en BDD
        $user->documents()->create([
            'type'          => $request->type,
            'path'          => $path,
            'original_name' => $fichier->getClientOriginalName(),
            'mime_type'     => $fichier->getMimeType(),
            'size'          => $fichier->getSize(),
            'status'        => 'en_attente',
        ]);

        return back()->with('success', 'Document déposé avec succès. Il sera vérifié par notre équipe.');
    }

    // ──────────────────────────────────────────
    // SUPPRESSION D'UN DOCUMENT
    // ──────────────────────────────────────────

    public function destroy(Document $document): RedirectResponse
    {
        // Sécurité : l'élève ne peut supprimer que SES propres documents
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        // Empêcher la suppression d'un document déjà validé
        if ($document->status === 'valide') {
            return back()->withErrors(['document' => 'Impossible de supprimer un document déjà validé. Contactez l\'administration.']);
        }

        // Supprimer le fichier physique du disque
        Storage::disk('private')->delete($document->path);

        // Supprimer l'entrée BDD
        $document->delete();

        return back()->with('success', 'Document supprimé.');
    }

    // ──────────────────────────────────────────
    // TÉLÉCHARGEMENT SÉCURISÉ
    // ──────────────────────────────────────────

    public function download(Document $document)
    {
        // L'élève ne peut télécharger que ses propres documents
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        if (! Storage::disk('private')->exists($document->path)) {
            abort(404, 'Fichier introuvable.');
        }

        return Storage::disk('private')->download($document->path, $document->original_name);
    }
}