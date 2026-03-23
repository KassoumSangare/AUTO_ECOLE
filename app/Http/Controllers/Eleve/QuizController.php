<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizScore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuizController extends Controller
{
    private const QUESTIONS_PAR_QUIZ = 20;
    private const SEUIL_REUSSITE     = 80;

    public function index(): View
    {
        $user   = Auth::user();
        $scores = $user->quizScores()->latest()->take(10)->get();

        $statsCode = $user->quizScores()->code()->selectRaw('
            COUNT(*) as total,
            AVG(percentage) as moyenne,
            MAX(percentage) as meilleur
        ')->first();

        $statsConduite = $user->quizScores()->conduite()->selectRaw('
            COUNT(*) as total,
            AVG(percentage) as moyenne,
            MAX(percentage) as meilleur
        ')->first();

        return view('eleve.quiz', compact('scores', 'statsCode', 'statsConduite'));
    }

    public function getQuestions(Request $request): JsonResponse
    {
        $request->validate(['category' => ['required', 'in:code,conduite']]);

        $questions = QuizQuestion::where('category', $request->category)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(self::QUESTIONS_PAR_QUIZ)
            ->get()
            ->map(fn($q) => $q->toApiArray());

        return response()->json([
            'questions'  => $questions,
            'total'      => $questions->count(),
            'category'   => $request->category,
            'time_limit' => 30 * 60,
        ]);
    }

    public function storeScore(Request $request): JsonResponse
    {
        $request->validate([
            'category'         => ['required', 'in:code,conduite'],
            'answers'          => ['required', 'array', 'min:1'],
            'answers.*.id'     => ['required', 'integer', 'exists:quiz_questions,id'],
            'answers.*.chosen' => ['required', 'integer', 'between:0,3'],
            'duration_seconds' => ['nullable', 'integer', 'min:0'],
        ]);

        $questionIds = collect($request->answers)->pluck('id')->unique();
        $questions   = QuizQuestion::whereIn('id', $questionIds)
                                   ->where('category', $request->category)
                                   ->get()->keyBy('id');

        $score       = 0;
        $corrections = [];

        foreach ($request->answers as $answer) {
            $question = $questions->get($answer['id']);
            if (! $question) continue;

            $isCorrect = (int) $answer['chosen'] === $question->correct_index;
            if ($isCorrect) $score++;

            $corrections[] = [
                'id'            => $question->id,
                'is_correct'    => $isCorrect,
                'correct_index' => $question->correct_index,
                'explication'   => $question->explication,
            ];
        }

        $totalQuestions = count($corrections);
        $percentage     = $totalQuestions > 0 ? round(($score / $totalQuestions) * 100, 2) : 0;

        $quizScore = QuizScore::create([
            'user_id'         => Auth::id(),
            'category'        => $request->category,
            'score'           => $score,
            'total_questions' => $totalQuestions,
            'duration_seconds'=> $request->duration_seconds,
        ]);

        return response()->json([
            'success'     => true,
            'score'       => $score,
            'total'       => $totalQuestions,
            'percentage'  => $percentage,
            'is_reussi'   => $percentage >= self::SEUIL_REUSSITE,
            'corrections' => $corrections,
            'record_id'   => $quizScore->id,
        ]);
    }
}