<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user   = Auth::user();

        $stats = [
            'documents'  => $user->documents()->count(),
            'quiz_code'  => $user->quizScores()->where('category', 'code')->avg('percentage') ?? 0,
            'quiz_cond'  => $user->quizScores()->where('category', 'conduite')->avg('percentage') ?? 0,
            'has_paid'   => $user->hasPaid(),
            'last_scores'=> $user->quizScores()->latest()->take(5)->get(),
        ];

        return view('eleve.dashboard', compact('user', 'stats'));
    }
}