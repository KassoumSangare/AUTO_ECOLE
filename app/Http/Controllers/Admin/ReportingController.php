<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PaymentsExport;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\QuizScore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ReportingController extends Controller
{
    public function index(Request $request): View
    {
        // ── Transactions Wave ────────────────────────────────
        $query = Payment::with('user')->latest();

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        if ($request->filled('statut')) {
            $query->where('status', $request->statut);
        }

        $payments = $query->paginate(20)->withQueryString();

        // ── Totaux financiers ────────────────────────────────
        $totaux = [
            'total_global'  => Payment::completed()->sum('amount'),
            'total_mois'    => Payment::completed()->whereMonth('paid_at', now()->month)->sum('amount'),
            'nb_transactions'=> Payment::completed()->count(),
            'nb_pending'    => Payment::pending()->count(),
        ];

        // ── Suivi pédagogique — Élèves en difficulté ─────────
        // Élèves avec moyenne < 60% OU qui n'ont pas encore passé de quiz
        $elevesEnDifficulte = User::eleves()
            ->with(['quizScores'])
            ->withAvg(['quizScores as moy_code' => fn($q) => $q->where('category','code')], 'percentage')
            ->withAvg(['quizScores as moy_conduite' => fn($q) => $q->where('category','conduite')], 'percentage')
            ->withCount('quizScores')
            ->having('moy_code', '<', 60)
            ->orHaving('moy_conduite', '<', 60)
            ->orHaving('quiz_scores_count', '=', 0)
            ->orderBy('moy_code')
            ->limit(20)
            ->get();

        // ── Top / Flop scores par catégorie ─────────────────
        $classementCode = QuizScore::code()
            ->selectRaw('user_id, AVG(percentage) as moyenne, COUNT(*) as nb, MAX(score) as meilleur')
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('moyenne')
            ->limit(10)
            ->get();

        $classementConduite = QuizScore::conduite()
            ->selectRaw('user_id, AVG(percentage) as moyenne, COUNT(*) as nb, MAX(score) as meilleur')
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('moyenne')
            ->limit(10)
            ->get();

        return view('admin.reporting.index', compact(
            'payments', 'totaux',
            'elevesEnDifficulte', 'classementCode', 'classementConduite'
        ));
    }

    public function exportExcel(Request $request)
    {
        $filename = 'transactions-wave-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(
            new PaymentsExport($request->date_debut, $request->date_fin),
            $filename
        );
    }
}