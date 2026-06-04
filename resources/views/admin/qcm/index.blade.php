@extends('layouts.app')
@section('title', 'Questions QCM')
@section('page-title', 'Questions QCM')

@section('head')
    <style>
        .card-a {
            background: #fff;
            border-radius: var(--r);
            padding: 1.4rem;
            border: 1.5px solid var(--border);
        }

        .btn-add {
            background: linear-gradient(135deg, var(--rouge), var(--rouge-c));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .6rem 1.2rem;
            font-weight: 700;
            font-size: .84rem;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            text-decoration: none;
            transition: .2s ease;
        }

        .btn-add:hover {
            opacity: .9;
            color: #fff;
            transform: translateY(-1px);
        }

        /* Tableau */
        .qcm-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .qcm-table thead th {
            font-size: .74rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--texte-2);
            padding: .65rem 1rem;
            border-bottom: 1.5px solid var(--border);
            background: var(--bg);
            white-space: nowrap;
        }

        .qcm-table thead th:first-child {
            border-radius: 10px 0 0 0;
        }

        .qcm-table thead th:last-child {
            border-radius: 0 10px 0 0;
        }

        .qcm-table tbody tr {
            transition: background .15s;
        }

        .qcm-table tbody tr:hover {
            background: var(--bg);
        }

        .qcm-table tbody td {
            padding: .85rem 1rem;
            font-size: .85rem;
            color: var(--texte);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .qcm-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge-cat {
            font-size: .7rem;
            font-weight: 700;
            padding: .25rem .7rem;
            border-radius: 50px;
            display: inline-block;
        }

        .badge-code {
            background: #EFF6FF;
            color: #1D4ED8;
        }

        .badge-conduite {
            background: #F0F7F4;
            color: #2D6A4F;
        }

        .badge-actif {
            background: var(--vert-p);
            color: var(--vert);
        }

        .badge-inactif {
            background: #F3F4F6;
            color: #6B7280;
        }

        /* ID pill */
        .id-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--rouge-p);
            color: var(--rouge);
            font-size: .72rem;
            font-weight: 800;
            font-family: monospace;
        }

        /* Question text */
        .q-text {
            font-weight: 600;
            color: var(--texte);
            line-height: 1.45;
        }

        .q-options {
            display: flex;
            flex-wrap: wrap;
            gap: .3rem;
            margin-top: .35rem;
        }

        .q-opt {
            font-size: .7rem;
            padding: .15rem .5rem;
            border-radius: 5px;
            background: var(--bg);
            color: var(--texte-2);
            border: 1px solid var(--border);
        }

        .q-opt.correct {
            background: var(--vert-p);
            color: var(--vert);
            border-color: var(--vert);
            font-weight: 700;
        }

        /* Actions */
        .btn-act {
            border: none;
            border-radius: 8px;
            padding: .35rem .7rem;
            font-size: .76rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            text-decoration: none;
            transition: .15s ease;
        }

        .btn-act:hover {
            transform: translateY(-1px);
        }

        .btn-edit {
            background: var(--bg);
            color: var(--texte-2);
            border: 1.5px solid var(--border);
        }

        .btn-edit:hover {
            border-color: var(--rouge);
            color: var(--rouge);
        }

        .btn-delete {
            background: var(--rouge-p);
            color: var(--rouge);
        }

        .btn-delete:hover {
            background: var(--rouge);
            color: #fff;
        }

        /* Filtres */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            align-items: center;
        }

        .filter-btn {
            padding: .35rem 1rem;
            border-radius: 50px;
            font-size: .8rem;
            font-weight: 700;
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--texte-2);
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
        }

        .filter-btn:hover,
        .filter-btn.active {
            border-color: var(--rouge);
            color: var(--rouge);
            background: var(--rouge-p);
        }

        /* Compteur */
        .total-badge {
            font-size: .82rem;
            color: var(--texte-2);
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .total-badge strong {
            color: var(--texte);
        }
    </style>
@endsection

@section('content')

    {{-- Barre supérieure --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div class="filter-bar">
            <a href="{{ route('admin.qcms.index') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap-fill me-1"></i>Tout
            </a>
            <a href="{{ route('admin.qcms.index', ['category' => 'code']) }}"
                class="filter-btn {{ request('category') === 'code' ? 'active' : '' }}">
                <i class="bi bi-book-fill me-1"></i>Code
            </a>
            <a href="{{ route('admin.qcms.index', ['category' => 'conduite']) }}"
                class="filter-btn {{ request('category') === 'conduite' ? 'active' : '' }}">
                <i class="bi bi-car-front-fill me-1"></i>Conduite
            </a>
        </div>
        <a href="{{ route('admin.qcms.create') }}" class="btn-add">
            <i class="bi bi-plus-circle-fill"></i>Ajouter une question
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-3" style="border-radius:12px;font-size:.88rem;">
            <i class="bi bi-check-circle-fill" style="color:var(--vert);"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card-a">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="total-badge">
                <i class="bi bi-patch-question-fill" style="color:var(--rouge);"></i>
                <strong>{{ $qcms->total() }}</strong> question(s)
            </div>
        </div>

        @if($qcms->isEmpty())
            <div class="text-center py-5" style="color:#9CA3AF;">
                <i class="bi bi-patch-question" style="font-size:2.5rem;display:block;margin-bottom:.75rem;"></i>
                Aucune question. <a href="{{ route('admin.qcms.create') }}">Ajouter la première</a>.
            </div>
        @else
            <div class="table-responsive">
                <table class="qcm-table">
                    <thead>
                        <tr>
                            <th style="width:44px;">#</th>
                            <th>Question & Options</th>
                            <th style="width:100px;">Catégorie</th>
                            <th style="width:80px;">Statut</th>
                            <th style="width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qcms as $q)
                            <tr>
                                <td><span class="id-pill">{{ $q->id }}</span></td>
                                <td>
                                    <div class="q-text">{{ Str::limit($q->question, 110) }}</div>
                                    @if($q->options)
                                        <div class="q-options">
                                            @foreach($q->options as $i => $opt)
                                                <span class="q-opt {{ $i == $q->correct_index ? 'correct' : '' }}">
                                                    {{ chr(65 + $i) }}. {{ Str::limit($opt, 30) }}
                                                    @if($i == $q->correct_index)<i class="bi bi-check2"></i>@endif
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-cat {{ $q->category === 'code' ? 'badge-code' : 'badge-conduite' }}">
                                        {{ ucfirst($q->category) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-cat {{ $q->is_active ? 'badge-actif' : 'badge-inactif' }}">
                                        {{ $q->is_active ? '✅ Actif' : '🔒 Inactif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.qcms.edit', $q) }}" class="btn-act btn-edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('admin.qcms.destroy', $q) }}" method="POST"
                                            onsubmit="return confirm('Supprimer cette question ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-act btn-delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $qcms->links() }}</div>
        @endif
    </div>

@endsection