@extends('layouts.app')
@section('title', 'Modifier la question')
@section('page-title', 'Modifier la question')

@section('head')
    <style>
        .form-card {
            background: #fff;
            border-radius: var(--r);
            padding: 2rem;
            border: 1.5px solid var(--border);
            max-width: 780px;
        }

        .lbl {
            font-size: .82rem;
            font-weight: 700;
            color: var(--texte);
            display: block;
            margin-bottom: .4rem;
        }

        .lbl span {
            color: var(--rouge);
        }

        .inp {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: .6rem .9rem;
            font-size: .88rem;
            width: 100%;
            transition: .2s;
            background: #fff;
            color: var(--texte);
        }

        .inp:focus {
            border-color: var(--rouge);
            outline: none;
            box-shadow: 0 0 0 3px rgba(175, 38, 54, .1);
        }

        textarea.inp {
            resize: vertical;
            min-height: 90px;
        }

        /* Options */
        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .85rem;
        }

        @media (max-width: 576px) {
            .options-grid {
                grid-template-columns: 1fr;
            }
        }

        .option-wrap {
            position: relative;
        }

        .option-letter {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            border-radius: 7px;
            background: var(--rouge-p);
            color: var(--rouge);
            font-size: .72rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            transition: .2s;
        }

        .option-wrap input {
            padding-left: 2.5rem;
        }

        .option-wrap.correct .option-letter {
            background: var(--vert);
            color: #fff;
        }

        .option-wrap.correct input {
            border-color: var(--vert);
            background: var(--vert-p);
        }

        /* Correct selector */
        .correct-selector {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .correct-btn {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            border: 2px solid var(--border);
            background: #fff;
            color: var(--texte-2);
            font-weight: 800;
            font-size: .9rem;
            cursor: pointer;
            transition: .2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .correct-btn:hover {
            border-color: var(--rouge);
            color: var(--rouge);
        }

        .correct-btn.selected {
            background: var(--vert);
            border-color: var(--vert);
            color: #fff;
        }

        /* Catégorie tabs */
        .cat-tabs {
            display: flex;
            gap: .5rem;
        }

        .cat-tab {
            flex: 1;
            padding: .6rem 1rem;
            border-radius: 10px;
            border: 2px solid var(--border);
            background: #fff;
            color: var(--texte-2);
            font-weight: 700;
            font-size: .84rem;
            cursor: pointer;
            transition: .2s;
            text-align: center;
        }

        .cat-tab:hover {
            border-color: var(--rouge);
            color: var(--rouge);
        }

        .cat-tab.active {
            background: var(--rouge);
            border-color: var(--rouge);
            color: #fff;
        }

        /* Toggle */
        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .85rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: .2s;
        }

        .toggle-wrap:hover {
            border-color: var(--rouge);
            background: var(--rouge-p);
        }

        .toggle-switch {
            width: 42px;
            height: 24px;
            border-radius: 50px;
            background: #D1D5DB;
            position: relative;
            transition: .25s;
            flex-shrink: 0;
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #fff;
            top: 3px;
            left: 3px;
            transition: .25s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
        }

        .toggle-wrap.on .toggle-switch {
            background: var(--vert);
        }

        .toggle-wrap.on .toggle-switch::after {
            left: 21px;
        }

        /* Section header */
        .section-header {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--texte-2);
            margin-bottom: 1rem;
            padding-bottom: .5rem;
            border-bottom: 1px solid var(--border);
        }

        .section-header i {
            color: var(--rouge);
        }

        /* Boutons */
        .btn-save {
            background: linear-gradient(135deg, var(--rouge), var(--rouge-c));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .75rem 2rem;
            font-weight: 700;
            font-size: .9rem;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            cursor: pointer;
            transition: .2s;
        }

        .btn-save:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .btn-back {
            background: var(--bg);
            color: var(--texte-2);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: .72rem 1.25rem;
            font-weight: 600;
            font-size: .88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: .2s;
        }

        .btn-back:hover {
            border-color: var(--rouge);
            color: var(--rouge);
        }

        /* Info pill ID */
        .id-info {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--rouge-p);
            color: var(--rouge);
            font-size: .78rem;
            font-weight: 700;
            padding: .3rem .75rem;
            border-radius: 50px;
            margin-bottom: 1.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="form-card">

        <div class="id-info">
            <i class="bi bi-hash"></i> Question #{{ $qcm->id }}
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-3" style="border-radius:12px;font-size:.85rem;">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.qcms.update', $qcm) }}" method="POST" id="qcmForm">
            @csrf @method('PUT')

            {{-- ── 1. Question ── --}}
            <div class="section-header"><i class="bi bi-chat-left-text-fill"></i>La question</div>
            <div class="mb-4">
                <label class="lbl">Énoncé <span>*</span></label>
                <textarea name="question" class="inp">{{ old('question', $qcm->question) }}</textarea>
            </div>

            {{-- ── 2. Options ── --}}
            <div class="section-header"><i class="bi bi-list-check"></i>Options de réponse</div>
            <div class="options-grid mb-3" id="optionsGrid">
                @for($i = 0; $i < 4; $i++)
                    <div class="option-wrap {{ old('correct_index', $qcm->correct_index) == $i ? 'correct' : '' }}"
                        id="wrap-{{ $i }}">
                        <div class="option-letter">{{ chr(65 + $i) }}</div>
                        <input type="text" name="options[]" class="inp" placeholder="Option {{ chr(65 + $i) }}"
                            value="{{ old('options.' . $i, $qcm->options[$i] ?? '') }}">
                    </div>
                @endfor
            </div>

            {{-- ── 3. Réponse correcte ── --}}
            <div class="mb-4">
                <label class="lbl">Réponse correcte <span>*</span></label>
                <div class="correct-selector">
                    @for($i = 0; $i < 4; $i++)
                        <button type="button"
                            class="correct-btn {{ old('correct_index', $qcm->correct_index) == $i ? 'selected' : '' }}"
                            data-index="{{ $i }}" onclick="selectCorrect({{ $i }})">
                            {{ chr(65 + $i) }}
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="correct_index" id="correctInput"
                    value="{{ old('correct_index', $qcm->correct_index) }}">
                <div style="font-size:.74rem;color:var(--texte-2);margin-top:.4rem;">
                    Cliquez sur la lettre correspondant à la bonne réponse.
                </div>
            </div>

            {{-- ── 4. Catégorie ── --}}
            <div class="section-header"><i class="bi bi-tag-fill"></i>Catégorie</div>
            <div class="mb-4">
                <div class="cat-tabs">
                    <div class="cat-tab {{ old('category', $qcm->category) === 'code' ? 'active' : '' }}"
                        onclick="selectCat('code', this)">
                        <i class="bi bi-book-fill me-1"></i>Code de la route
                    </div>
                    <div class="cat-tab {{ old('category', $qcm->category) === 'conduite' ? 'active' : '' }}"
                        onclick="selectCat('conduite', this)">
                        <i class="bi bi-car-front-fill me-1"></i>Conduite
                    </div>
                </div>
                <input type="hidden" name="category" id="categoryInput" value="{{ old('category', $qcm->category) }}">
            </div>

            {{-- ── 5. Explication ── --}}
            <div class="section-header"><i class="bi bi-lightbulb-fill"></i>Explication <span
                    style="font-weight:400;text-transform:none;letter-spacing:0;">(optionnel)</span></div>
            <div class="mb-4">
                <textarea name="explication" class="inp"
                    placeholder="Ex: La règle de priorité à droite s'applique...">{{ old('explication', $qcm->explication) }}</textarea>
            </div>

            {{-- ── 6. Statut ── --}}
            <div class="mb-4">
                <div class="toggle-wrap {{ old('is_active', $qcm->is_active) ? 'on' : '' }}" id="toggleWrap"
                    onclick="toggleActive()">
                    <div class="toggle-switch"></div>
                    <div>
                        <div style="font-weight:700;font-size:.88rem;color:var(--texte);" id="toggleLabel">
                            {{ old('is_active', $qcm->is_active) ? 'Question active' : 'Question inactive' }}
                        </div>
                        <div style="font-size:.76rem;color:var(--texte-2);">Les élèves verront cette question dans les quiz
                        </div>
                    </div>
                </div>
                <input type="hidden" name="is_active" id="isActiveInput"
                    value="{{ old('is_active', $qcm->is_active) ? 1 : 0 }}">
            </div>

            <div class="d-flex gap-2 align-items-center">
                <button type="submit" class="btn-save">
                    <i class="bi bi-floppy-fill"></i>Mettre à jour
                </button>
                <a href="{{ route('admin.qcms.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i>Retour
                </a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function selectCorrect(index) {
            document.querySelectorAll('.correct-btn').forEach((b, i) => {
                b.classList.toggle('selected', i === index);
            });
            document.querySelectorAll('.option-wrap').forEach((w, i) => {
                w.classList.toggle('correct', i === index);
            });
            document.getElementById('correctInput').value = index;
        }

        function selectCat(val, el) {
            document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('categoryInput').value = val;
        }

        function toggleActive() {
            const wrap = document.getElementById('toggleWrap');
            const input = document.getElementById('isActiveInput');
            const label = document.getElementById('toggleLabel');
            const isOn = wrap.classList.toggle('on');
            input.value = isOn ? 1 : 0;
            label.textContent = isOn ? 'Question active' : 'Question inactive';
        }
    </script>
@endsection