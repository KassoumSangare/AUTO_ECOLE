<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminDocumentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Document::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nom', 'like', "%{$request->search}%")
                  ->orWhere('prenom', 'like', "%{$request->search}%")
                  ->orWhere('telephone', 'like', "%{$request->search}%");
            });
        }

        $documents = $query->paginate(25)->withQueryString();
        $stats = [
            'total'      => Document::count(),
            'en_attente' => Document::where('status','en_attente')->count(),
            'valides'    => Document::where('status','valide')->count(),
            'rejetes'    => Document::where('status','rejete')->count(),
        ];

        return view('admin.documents.index', compact('documents', 'stats'));
    }

    public function updateStatus(Request $request, Document $document)
    {
        $request->validate([
            'status'              => ['required', 'in:valide,rejete,en_attente'],
            'commentaire_admin'   => ['nullable', 'string', 'max:500'],
        ]);

        $document->update([
            'status'            => $request->status,
            'commentaire_admin' => $request->commentaire_admin,
        ]);

        return response()->json([
            'success' => true,
            'status'  => $document->status,
            'message' => 'Statut mis à jour.',
        ]);
    }

    public function download(Document $document)
    {
        if (! Storage::disk('private')->exists($document->path)) {
            abort(404, 'Fichier introuvable.');
        }
        return Storage::disk('private')->download($document->path, $document->original_name);
    }

    public function printAll(Request $request)
    {
        $documents = Document::with('user')
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->get();

        return view('admin.documents.print', compact('documents'));
    }
}