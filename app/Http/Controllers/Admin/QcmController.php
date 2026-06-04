<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QcmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $qcms = QuizQuestion::orderByDesc('created_at')->paginate(20);
        return view('admin.qcm.index', compact('qcms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.qcm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'question' => 'required|string|max:1000',
            'options' => 'required|array|size:4',
            'options.*' => 'required|string|max:255',
            'correct_index' => 'required|integer|min:0|max:3',
            'category' => 'required|in:code,conduite',
            'explication' => 'nullable|string|max:2000',
            'is_active' => 'sometimes|boolean',
        ]);

        // Le checkbox envoie sa présence : utiliser has() pour définir le booléen
        $data['is_active'] = $request->has('is_active');

        QuizQuestion::create([
            'question' => $data['question'],
            'options' => $data['options'],
            'correct_index' => $data['correct_index'],
            'category' => $data['category'],
            'explication' => $data['explication'] ?? null,
            'is_active' => $data['is_active'],
        ]);

        return redirect()->route('admin.qcms.index')->with('success', 'Question ajoutée.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuizQuestion $qcm): View
    {
        return view('admin.qcm.edit', compact('qcm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuizQuestion $qcm): RedirectResponse
    {
        $data = $request->validate([
            'question' => 'required|string|max:1000',
            'options' => 'required|array|size:4',
            'options.*' => 'required|string|max:255',
            'correct_index' => 'required|integer|min:0|max:3',
            'category' => 'required|in:code,conduite',
            'explication' => 'nullable|string|max:2000',
            'is_active' => 'sometimes|boolean',
        ]);

        $qcm->update([
            'question' => $data['question'],
            'options' => $data['options'],
            'correct_index' => $data['correct_index'],
            'category' => $data['category'],
            'explication' => $data['explication'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.qcms.index')->with('success', 'Question mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizQuestion $qcm): RedirectResponse
    {
        $qcm->delete();
        return back()->with('success', 'Question supprimée.');
    }
}
