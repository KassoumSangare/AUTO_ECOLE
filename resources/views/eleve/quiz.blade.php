@extends('layouts.app')
@section('title', 'Quiz QCM')
@section('page-title', 'Quiz QCM')

@section('head')
<style>
    /* ═══════════════════════════════════════════════════
   VARIABLES
═══════════════════════════════════════════════════ */
    /* ═══════════════════════════════════════════════════
   ÉCRAN D'ACCUEIL DU QUIZ
═══════════════════════════════════════════════════ */
    .quiz-home {
        animation: fadeIn .4s ease;
    }

    .cat-card {
        background: #fff;
        border: 2px solid var(--border);
        border-radius: var(--radius);
        padding: 2rem;
        cursor: pointer;
        transition: var(--trans);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cat-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--bleu), var(--bleu-c));
        opacity: 0;
        transition: var(--trans);
    }

    .cat-card:hover {
        border-color: var(--bleu-c);
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(11, 37, 69, .12);
    }

    .cat-card:hover::before {
        opacity: 1;
    }

    .cat-card:hover .cat-icon,
    .cat-card:hover .cat-title,
    .cat-card:hover .cat-desc,
    .cat-card:hover .cat-meta {
        color: #fff !important;
        position: relative;
        z-index: 1;
    }

    .cat-card:hover .cat-icon {
        background: rgba(255, 255, 255, .15) !important;
    }

    .cat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin: 0 auto 1rem;
        transition: var(--trans);
        position: relative;
        z-index: 1;
    }

    .cat-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: .35rem;
        transition: var(--trans);
        position: relative;
        z-index: 1;
    }

    .cat-desc {
        font-size: .83rem;
        color: var(--texte-2);
        margin-bottom: .75rem;
        transition: var(--trans);
        position: relative;
        z-index: 1;
    }

    .cat-meta {
        font-size: .78rem;
        color: #9CA3AF;
        transition: var(--trans);
        position: relative;
        z-index: 1;
    }

    .stat-mini {
        background: var(--bg);
        border-radius: 12px;
        padding: .75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .5rem;
        font-size: .85rem;
    }

    .stat-mini .val {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        color: var(--bleu);
    }

    /* ═══════════════════════════════════════════════════
   MOTEUR DE QUIZ
═══════════════════════════════════════════════════ */
    #quizEngine {
        display: none;
        animation: fadeIn .4s ease;
    }

    /* Barre de progression */
    .progress-container {
        background: #fff;
        border-radius: var(--radius);
        padding: 1.25rem 1.5rem;
        border: 1.5px solid var(--border);
        margin-bottom: 1.25rem;
    }

    .progress-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .75rem;
    }

    .q-counter {
        font-family: 'Syne', sans-serif;
        font-size: .85rem;
        font-weight: 700;
        color: var(--bleu);
    }

    .timer-badge {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .95rem;
        color: var(--bleu);
        background: var(--bg);
        padding: .3rem .75rem;
        border-radius: 50px;
        transition: color .3s, background .3s;
    }

    .timer-badge.urgent {
        color: var(--rouge);
        background: #FFE8E8;
        animation: pulse-timer .8s infinite;
    }

    @keyframes pulse-timer {

        0%,
        100% {
            opacity: 1
        }

        50% {
            opacity: .6
        }
    }

    .progress-bar-track {
        height: 8px;
        background: var(--border);
        border-radius: 50px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 50px;
        background: linear-gradient(90deg, var(--bleu-c), var(--or));
        transition: width .5s cubic-bezier(.4, 0, .2, 1);
        width: 0%;
    }

    /* Carte de question */
    .question-card {
        background: #fff;
        border-radius: var(--radius);
        padding: 2rem;
        border: 1.5px solid var(--border);
        margin-bottom: 1rem;
        animation: slideUp .35s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(16px)
        }

        to {
            opacity: 1;
            transform: none
        }
    }

    .question-number {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--or);
        font-weight: 700;
        margin-bottom: .75rem;
    }

    .question-text {
        font-family: 'Syne', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--bleu);
        line-height: 1.45;
        margin-bottom: 1.5rem;
    }

    /* Options */
    .options-grid {
        display: flex;
        flex-direction: column;
        gap: .65rem;
    }

    .option-btn {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: .85rem 1.1rem;
        border: 2px solid var(--border);
        border-radius: 12px;
        background: #fff;
        cursor: pointer;
        transition: var(--trans);
        width: 100%;
        text-align: left;
        font-size: .92rem;
        color: var(--bleu);
        position: relative;
        overflow: hidden;
    }

    .option-btn:hover:not(:disabled) {
        border-color: var(--bleu-c);
        background: #F0F8FF;
        transform: translateX(4px);
    }

    .option-letter {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .85rem;
        background: var(--bg);
        color: var(--bleu);
        flex-shrink: 0;
        transition: var(--trans);
    }

    .option-btn:hover:not(:disabled) .option-letter {
        background: var(--bleu-c);
        color: #fff;
    }

    /* États après validation */
    .option-btn.correct {
        border-color: var(--vert) !important;
        background: #E8FFE8 !important;
    }

    .option-btn.correct .option-letter {
        background: var(--vert) !important;
        color: #fff !important;
    }

    .option-btn.wrong {
        border-color: var(--rouge) !important;
        background: #FFE8E8 !important;
    }

    .option-btn.wrong .option-letter {
        background: var(--rouge) !important;
        color: #fff !important;
    }

    .option-btn.dimmed {
        opacity: .45;
    }

    .option-btn:disabled {
        cursor: default;
        transform: none !important;
    }

    /* Explication */
    .explication-box {
        background: #FEFCE8;
        border-left: 3px solid var(--or);
        border-radius: 0 10px 10px 0;
        padding: .85rem 1rem;
        font-size: .85rem;
        color: #78350F;
        margin-top: .75rem;
        display: none;
        animation: fadeIn .3s ease;
    }

    .explication-box.show {
        display: block;
    }

    /* Bouton suivant */
    .btn-next {
        background: linear-gradient(135deg, var(--bleu), var(--bleu-c));
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: .8rem 2rem;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: .95rem;
        cursor: pointer;
        transition: var(--trans);
        display: none;
        margin-top: 1rem;
        width: 100%;
    }

    .btn-next:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(11, 37, 69, .3);
    }

    .btn-next.show {
        display: block;
    }

    /* ═══════════════════════════════════════════════════
   ÉCRAN DE RÉSULTATS
═══════════════════════════════════════════════════ */
    #quizResults {
        display: none;
        animation: fadeIn .5s ease;
    }

    .result-card {
        background: #fff;
        border-radius: 20px;
        padding: 2.5rem;
        border: 1.5px solid var(--border);
        text-align: center;
        margin-bottom: 1.25rem;
    }

    .score-circle {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        position: relative;
        border: 6px solid var(--or);
    }

    .score-circle.reussi {
        border-color: var(--vert);
        background: #E8FFE8;
    }

    .score-circle.echec {
        border-color: var(--rouge);
        background: #FFE8E8;
    }

    .score-pct {
        font-family: 'Syne', sans-serif;
        font-size: 2rem;
        font-weight: 900;
        line-height: 1;
    }

    .score-label {
        font-size: .72rem;
        color: var(--texte-2);
        margin-top: .2rem;
    }

    .correction-item {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        padding: .85rem;
        border-radius: 12px;
        margin-bottom: .5rem;
        border: 1px solid transparent;
        text-align: left;
        font-size: .85rem;
    }

    .correction-item.ok {
        background: #E8FFE8;
        border-color: #C3E6CB;
    }

    .correction-item.ko {
        background: #FFE8E8;
        border-color: #F5C6CB;
    }

    .correction-icon {
        font-size: 1.1rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ═══════════════════════════════════════════════════
   LOADING
═══════════════════════════════════════════════════ */
    #quizLoading {
        display: none;
        text-align: center;
        padding: 3rem;
    }

    .spinner-wave {
        display: flex;
        align-items: flex-end;
        gap: 6px;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .spinner-wave span {
        width: 8px;
        border-radius: 4px;
        background: var(--bleu-c);
        animation: wave-bar .9s ease-in-out infinite;
    }

    .spinner-wave span:nth-child(1) {
        height: 20px;
        animation-delay: 0s
    }

    .spinner-wave span:nth-child(2) {
        height: 35px;
        animation-delay: .15s
    }

    .spinner-wave span:nth-child(3) {
        height: 25px;
        animation-delay: .3s
    }

    .spinner-wave span:nth-child(4) {
        height: 40px;
        animation-delay: .45s
    }

    .spinner-wave span:nth-child(5) {
        height: 20px;
        animation-delay: .6s
    }

    @keyframes wave-bar {

        0%,
        100% {
            transform: scaleY(.5);
            opacity: .5
        }

        50% {
            transform: scaleY(1);
            opacity: 1
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0
        }

        to {
            opacity: 1
        }
    }

    /* Historique */
    .history-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .6rem .75rem;
        border-radius: 10px;
        margin-bottom: .35rem;
        font-size: .85rem;
    }

    .history-row.ok {
        background: #E8FFE8;
    }

    .history-row.ko {
        background: #FFE8E8;
    }
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════
     ÉCRAN D'ACCUEIL
══════════════════════════════════ --}}
<div id="quizHome" class="quiz-home">

    <div class="row g-3 mb-4">
        {{-- Carte Code --}}
        <div class="col-md-6">
            <div class="cat-card" onclick="startQuiz('code')">
                <div class="cat-icon" style="background:#E8F4FF;color:var(--vert);">
                    <i class="bi bi-signpost-2-fill"></i>
                </div>
                <div class="cat-title" style="color:var(--texte);">Code de la route</div>
                <div class="cat-desc">Signalisation, priorités, réglementation</div>
                <div class="cat-meta">
                    <i class="bi bi-list-ol me-1"></i>20 questions · 30 minutes
                </div>
            </div>
        </div>
        {{-- Carte Conduite --}}
        <div class="col-md-6">
            <div class="cat-card" onclick="startQuiz('conduite')">
                <div class="cat-icon" style="background:#FEFCE8;color:var(--or);">
                    <i class="bi bi-steering2"></i>
                </div>
                <div class="cat-title" style="color:var(--texte);">Conduite</div>
                <div class="cat-desc">Techniques de conduite et situations pratiques</div>
                <div class="cat-meta">
                    <i class="bi bi-list-ol me-1"></i>20 questions · 30 minutes
                </div>
            </div>
        </div>
    </div>

    {{-- Stats personnelles --}}
    <div class="row g-3">
        <div class="col-md-6">
            <div style="background:#fff;border-radius:16px;padding:1.5rem;border:1.5px solid var(--border);">
                <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1rem;">
                    <i class="bi bi-bar-chart-fill me-2" style="color:var(--vert);"></i>
                    Mes stats — Code
                </h6>
                @if($statsCode->total > 0)
                <div class="stat-mini"><span>Quiz effectués</span><span class="val">{{ $statsCode->total }}</span></div>
                <div class="stat-mini"><span>Moyenne</span><span class="val">{{ number_format($statsCode->moyenne, 0) }}%</span></div>
                <div class="stat-mini"><span>Meilleur score</span><span class="val">{{ number_format($statsCode->meilleur, 0) }}%</span></div>
                @else
                <p class="text-muted text-center py-2" style="font-size:.85rem;">Aucun quiz effectué</p>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div style="background:#fff;border-radius:16px;padding:1.5rem;border:1.5px solid var(--border);">
                <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1rem;">
                    <i class="bi bi-bar-chart-fill me-2" style="color:var(--or);"></i>
                    Mes stats — Conduite
                </h6>
                @if($statsConduite->total > 0)
                <div class="stat-mini"><span>Quiz effectués</span><span class="val">{{ $statsConduite->total }}</span></div>
                <div class="stat-mini"><span>Moyenne</span><span class="val">{{ number_format($statsConduite->moyenne, 0) }}%</span></div>
                <div class="stat-mini"><span>Meilleur score</span><span class="val">{{ number_format($statsConduite->meilleur, 0) }}%</span></div>
                @else
                <p class="text-muted text-center py-2" style="font-size:.85rem;">Aucun quiz effectué</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Historique --}}
    @if($scores->count())
    <div style="background:#fff;border-radius:16px;padding:1.5rem;border:1.5px solid var(--border);margin-top:1rem;">
        <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1rem;">
            <i class="bi bi-clock-history me-2" style="color:var(--texte-2);"></i>
            Historique récent
        </h6>
        @foreach($scores as $s)
        <div class="history-row {{ $s->is_reussi ? 'ok' : 'ko' }}">
            <span>
                <span class="badge" style="background:{{ $s->category==='code'?'#E8F4FF':'#FEFCE8' }};color:{{ $s->category==='code'?'var(--vert)':'var(--or)' }};font-size:.72rem;">
                    {{ ucfirst($s->category) }}
                </span>
                <span class="ms-2 text-muted" style="font-size:.78rem;">{{ $s->created_at->diffForHumans() }}</span>
            </span>
            <strong style="color:{{ $s->is_reussi ? 'var(--vert)' : 'var(--rouge)' }};">
                {{ $s->score }}/{{ $s->total_questions }} ({{ number_format($s->percentage,0) }}%)
            </strong>
        </div>
        @endforeach
    </div>
    @endif

</div>

{{-- ══════════════════════════════════
     LOADING
══════════════════════════════════ --}}
<div id="quizLoading">
    <div class="spinner-wave">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <p style="color:var(--texte-2);font-size:.9rem;">Chargement des questions…</p>
</div>

{{-- ══════════════════════════════════
     MOTEUR DE QUIZ
══════════════════════════════════ --}}
<div id="quizEngine">

    {{-- Barre de progression --}}
    <div class="progress-container">
        <div class="progress-top">
            <span class="q-counter" id="qCounter">Question 1 / 20</span>
            <div class="timer-badge" id="timerBadge">
                <i class="bi bi-stopwatch-fill"></i>
                <span id="timerDisplay">30:00</span>
            </div>
        </div>
        <div class="progress-bar-track">
            <div class="progress-bar-fill" id="progressFill"></div>
        </div>
    </div>

    {{-- Carte question --}}
    <div class="question-card" id="questionCard">
        <div class="question-number" id="questionNumber">Question 1</div>
        <div class="question-text" id="questionText">Chargement…</div>
        <div class="options-grid" id="optionsGrid"></div>
        <div class="explication-box" id="expliBox">
            <i class="bi bi-lightbulb-fill me-2"></i>
            <span id="expliText"></span>
        </div>
        <button class="btn-next" id="btnNext" onclick="nextQuestion()">
            Suivant <i class="bi bi-arrow-right ms-1"></i>
        </button>
    </div>

</div>

{{-- ══════════════════════════════════
     RÉSULTATS
══════════════════════════════════ --}}
<div id="quizResults">

    <div class="result-card">
        {{-- Cercle score --}}
        <div class="score-circle" id="scoreCircle">
            <div class="score-pct" id="scorePct">—</div>
            <div class="score-label">Score</div>
        </div>

        <h4 style="font-family:'Syne',sans-serif;font-weight:800;color:var(--texte);" id="resultTitle">—</h4>
        <p class="text-muted mb-3" id="resultSub" style="font-size:.9rem;">—</p>

        <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;">
            <button class="btn" style="background:var(--texte);color:#fff;border-radius:10px;font-weight:700;padding:.65rem 1.5rem;"
                onclick="retryQuiz()">
                <i class="bi bi-arrow-repeat me-2"></i>Refaire un quiz
            </button>
            <button class="btn" style="background:var(--border);color:var(--texte);border-radius:10px;font-weight:700;padding:.65rem 1.5rem;"
                onclick="showHome()">
                <i class="bi bi-house-fill me-2"></i>Accueil
            </button>
        </div>
    </div>

    {{-- Corrections --}}
    <div style="background:#fff;border-radius:16px;padding:1.5rem;border:1.5px solid var(--border);">
        <h6 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1rem;">
            <i class="bi bi-patch-check me-2" style="color:var(--or);"></i>
            Corrections détaillées
        </h6>
        <div id="correctionsList"></div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    /* ════════════════════════════════════════════════════════
   AUTO-ÉCOLE LE CHEMIN — MOTEUR QCM VANILLA JS
   Version 1.0 — Correction côté serveur
════════════════════════════════════════════════════════ */

    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    // ── État global du quiz ──────────────────────────────────
    const state = {
        category: null,
        questions: [],
        current: 0,
        answers: [], // [{id, chosen}]
        answered: false, // Question courante répondue ?
        startTime: null,
        timerInterval: null,
        timeLimit: 30 * 60, // 30 min en secondes
        timeLeft: 30 * 60,
    };

    // ── Sélecteurs DOM ──────────────────────────────────────
    const $ = id => document.getElementById(id);

    // ── Écrans ───────────────────────────────────────────────
    function showScreen(screenId) {
        ['quizHome', 'quizLoading', 'quizEngine', 'quizResults']
        .forEach(id => $(id).style.display = 'none');
        $(screenId).style.display = 'block';
    }

    function showHome() {
        clearInterval(state.timerInterval);
        showScreen('quizHome');
    }

    // ── Démarrer le quiz ─────────────────────────────────────
    async function startQuiz(category) {
        state.category = category;
        state.current = 0;
        state.answers = [];
        state.answered = false;

        showScreen('quizLoading');

        try {
            const res = await fetch(`/espace-eleve/quiz/questions?category=${category}`, {
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                }
            });

            console.log('Response status:', res.status, res.statusText);
            
            if (!res.ok) {
                const errorText = await res.text();
                console.error('Erreur serveur:', res.status, errorText);
                throw new Error(`Erreur ${res.status}: ${res.statusText}`);
            }

            const data = await res.json();
            console.log('Données reçues:', data);
            
            if (!data.questions || data.questions.length === 0) {
                throw new Error('Aucune question disponible pour cette catégorie.');
            }
            
            state.questions = data.questions;
            state.timeLimit = data.time_limit;
            state.timeLeft = data.time_limit;
            state.startTime = Date.now();

            startTimer();
            showScreen('quizEngine');
            renderQuestion();

        } catch (err) {
            console.error('Erreur complète:', err);
            alert('Impossible de charger les questions.\n\n' + (err.message || 'Vérifiez votre connexion.'));
            showScreen('quizHome');
        }
    }

    // ── Timer ─────────────────────────────────────────────────
    function startTimer() {
        clearInterval(state.timerInterval);
        updateTimerDisplay();

        state.timerInterval = setInterval(() => {
            state.timeLeft--;
            updateTimerDisplay();

            if (state.timeLeft <= 0) {
                clearInterval(state.timerInterval);
                submitQuiz(); // Soumission automatique à la fin du temps
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const m = Math.floor(state.timeLeft / 60);
        const s = state.timeLeft % 60;
        $('timerDisplay').textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;

        const badge = $('timerBadge');
        if (state.timeLeft <= 120) { // Rouge sous 2 min
            badge.classList.add('urgent');
        } else {
            badge.classList.remove('urgent');
        }
    }

    // ── Rendre une question ───────────────────────────────────
    function renderQuestion() {
        const q = state.questions[state.current];
        const total = state.questions.length;
        const idx = state.current + 1;

        // Compteur + barre de progression
        $('qCounter').textContent = `Question ${idx} / ${total}`;
        $('questionNumber').textContent = `Question ${idx}`;
        $('progressFill').style.width = `${((state.current) / total) * 100}%`;

        // Texte question
        $('questionText').textContent = q.question;

        // Cacher explication + bouton
        const expliBox = $('expliBox');
        expliBox.classList.remove('show');
        const btnNext = $('btnNext');
        btnNext.classList.remove('show');
        btnNext.textContent = (state.current === total - 1) ?
            '✅ Terminer le quiz' :
            'Suivant →';

        state.answered = false;

        // Générer les options
        const grid = $('optionsGrid');
        grid.innerHTML = '';
        const letters = ['A', 'B', 'C', 'D'];

        q.options.forEach((opt, i) => {
            const btn = document.createElement('button');
            btn.className = 'option-btn';
            btn.setAttribute('data-index', i);
            btn.innerHTML = `
            <span class="option-letter">${letters[i]}</span>
            <span>${opt}</span>
        `;
            btn.addEventListener('click', () => handleAnswer(i, q.id));
            grid.appendChild(btn);
        });
    }

    // ── Gérer une réponse ────────────────────────────────────
    function handleAnswer(chosenIndex, questionId) {
        if (state.answered) return;
        state.answered = true;

        // Enregistrer la réponse
        state.answers.push({
            id: questionId,
            chosen: chosenIndex
        });

        // Désactiver tous les boutons
        const buttons = document.querySelectorAll('.option-btn');
        buttons.forEach(btn => btn.disabled = true);

        // Mise en surbrillance de la réponse choisie
        // (On n'a pas la bonne réponse côté client — on montre juste la sélection)
        buttons.forEach(btn => {
            const idx = parseInt(btn.getAttribute('data-index'));
            if (idx === chosenIndex) {
                btn.classList.add('correct'); // Provisoire — sera confirmé en résultats
            } else {
                btn.classList.add('dimmed');
            }
        });

        // Afficher explication si disponible
        const q = state.questions[state.current];
        if (q.explication) {
            $('expliText').textContent = q.explication;
            $('expliBox').classList.add('show');
        }

        // Afficher bouton suivant
        $('btnNext').classList.add('show');
    }

    // ── Question suivante ─────────────────────────────────────
    function nextQuestion() {
        if (!state.answered && state.questions.length > 0) return;

        state.current++;

        if (state.current >= state.questions.length) {
            submitQuiz();
        } else {
            renderQuestion();
            // Scroll en haut de la carte
            document.getElementById('questionCard').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // ── Soumettre le quiz (Fetch API) ─────────────────────────
    async function submitQuiz() {
        clearInterval(state.timerInterval);

        const durationSeconds = Math.round((Date.now() - state.startTime) / 1000);

        showScreen('quizLoading');

        try {
            const res = await fetch('/api/quiz/score', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    category: state.category,
                    answers: state.answers,
                    duration_seconds: durationSeconds,
                }),
            });

            if (!res.ok) {
                const err = await res.json();
                throw new Error(err.message || 'Erreur serveur');
            }

            const result = await res.json();
            showResults(result);

        } catch (err) {
            console.error(err);
            alert('Erreur lors de l\'enregistrement du score : ' + err.message);
            showScreen('quizHome');
        }
    }

    // ── Afficher les résultats ────────────────────────────────
    function showResults(result) {
        showScreen('quizResults');

        const pct = Math.round(result.percentage);
        const reussi = result.is_reussi;
        const circle = $('scoreCircle');

        // Cercle score
        $('scorePct').textContent = pct + '%';
        circle.classList.toggle('reussi', reussi);
        circle.classList.toggle('echec', !reussi);

        // Titre + sous-titre
        $('resultTitle').textContent = reussi ?
            '🎉 Félicitations, vous avez réussi !' :
            '😕 Pas encore — continuez à vous entraîner';

        $('resultSub').textContent =
            `Score : ${result.score}/${result.total} — ${pct}% ` +
            (reussi ? '(seuil de réussite : 80%)' : `(il manquait ${80 - pct} point${80-pct>1?'s':''} pour réussir)`);

        // Corrections détaillées
        const list = $('correctionsList');
        list.innerHTML = '';
        const letters = ['A', 'B', 'C', 'D'];

        result.corrections.forEach((c, i) => {
            const q = state.questions.find(q => q.id === c.id);
            const ok = c.is_correct;

            // Mettre à jour la couleur des options (on a maintenant la vraie réponse)
            const div = document.createElement('div');
            div.className = `correction-item ${ok ? 'ok' : 'ko'}`;
            div.innerHTML = `
            <span class="correction-icon">${ok ? '✅' : '❌'}</span>
            <div>
                <div style="font-weight:700;margin-bottom:.25rem;">${i+1}. ${q ? q.question : '—'}</div>
                ${!ok && q ? `<div style="font-size:.8rem;color:var(--texte-2);margin-bottom:.25rem;">
                    Bonne réponse : <strong>${letters[c.correct_index]}. ${q.options[c.correct_index]}</strong>
                </div>` : ''}
                ${c.explication ? `<div style="font-size:.8rem;color:#78350F;">
                    💡 ${c.explication}
                </div>` : ''}
            </div>
        `;
            list.appendChild(div);
        });

        // Scroll en haut
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // ── Refaire un quiz ───────────────────────────────────────
    function retryQuiz() {
        if (state.category) startQuiz(state.category);
        else showHome();
    }
</script>
@endsection