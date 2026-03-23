<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ElevesExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EleveController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::eleves()
            ->with(['payments' => fn($q) => $q->where('status','completed'), 'quizScores', 'documents'])
            ->withCount(['quizScores', 'documents']);

        // Filtre date
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        // Filtre statut paiement
        if ($request->filled('statut')) {
            if ($request->statut === 'paye') {
                $query->whereHas('payments', fn($q) => $q->where('status','completed'));
            } elseif ($request->statut === 'non_paye') {
                $query->whereDoesntHave('payments', fn($q) => $q->where('status','completed'));
            }
        }

        $eleves = $query->latest()->paginate(20)->withQueryString();

        return view('admin.eleves.index', compact('eleves'));
    }

    public function show(User $user): View
    {
        $user->load(['payments', 'documents', 'quizScores']);
        return view('admin.eleves.show', compact('user'));
    }

    public function export()
    {
        $filename = 'eleves-auto-ecole-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new ElevesExport, $filename);
    }
}