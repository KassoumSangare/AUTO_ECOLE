<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\QuizScore;
use App\Models\User;
use App\Models\Document;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalEleves   = User::eleves()->count();
        $elevesPayes   = User::eleves()->whereHas('payments', fn($q) => $q->where('status', 'completed'))->count();
        $totalRevenu   = Payment::completed()->sum('amount');
        $revenuMois    = Payment::completed()->whereMonth('paid_at', now()->month)->sum('amount');
        $docsEnAttente = Document::enAttente()->count();
        $quizAujourdhui = QuizScore::whereDate('created_at', today())->count();

        $revenusParMois = Payment::completed()
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as mois, SUM(amount) as total, COUNT(*) as nb")
            ->where('paid_at', '>=', now()->subMonths(6))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        $topEleves = QuizScore::selectRaw('user_id, AVG(percentage) as moyenne, COUNT(*) as nb_quiz')
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('moyenne')
            ->limit(5)
            ->get();

        $inscriptionsRecentes = User::eleves()->with('payments')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalEleves',
            'elevesPayes',
            'totalRevenu',
            'revenuMois',
            'docsEnAttente',
            'quizAujourdhui',
            'revenusParMois',
            'topEleves',
            'inscriptionsRecentes'
        ));
    }
}
