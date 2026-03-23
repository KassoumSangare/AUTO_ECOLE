<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ElevesExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    public function title(): string
    {
        return 'Élèves inscrits';
    }

    public function query()
    {
        return User::eleves()
            ->with(['payments' => fn($q) => $q->where('status', 'completed'), 'quizScores'])
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Prénom',
            'Téléphone',
            'Email',
            'Date inscription',
            'Statut paiement',
            'Montant payé (XOF)',
            'Nb. Quiz Code',
            'Moy. Score Code (%)',
            'Nb. Quiz Conduite',
            'Moy. Score Conduite (%)',
        ];
    }

    public function map($user): array
    {
        $payment     = $user->payments->first();
        $quizCode    = $user->quizScores->where('category', 'code');
        $quizCond    = $user->quizScores->where('category', 'conduite');

        return [
            $user->id,
            strtoupper($user->nom),
            $user->prenom,
            $user->telephone,
            $user->email ?? '—',
            $user->created_at->format('d/m/Y'),
            $payment ? 'Payé' : 'Non payé',
            $payment ? number_format($payment->amount, 0, ',', ' ') : '0',
            $quizCode->count(),
            $quizCode->count() ? round($quizCode->avg('percentage'), 1) : '—',
            $quizCond->count(),
            $quizCond->count() ? round($quizCond->avg('percentage'), 1) : '—',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // En-tête : fond bleu foncé + texte blanc + gras
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0B2545']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}