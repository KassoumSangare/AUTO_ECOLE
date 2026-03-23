<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PaymentsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    public function __construct(
        private ?string $dateDebut = null,
        private ?string $dateFin   = null,
    ) {}

    public function title(): string
    {
        return 'Transactions Wave';
    }

    public function query()
    {
        $query = Payment::with('user')
            ->where('status', 'completed')
            ->orderBy('paid_at', 'desc');

        if ($this->dateDebut) {
            $query->whereDate('paid_at', '>=', $this->dateDebut);
        }
        if ($this->dateFin) {
            $query->whereDate('paid_at', '<=', $this->dateFin);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'N° Reçu',
            'Référence Wave',
            'Élève',
            'Téléphone',
            'Montant (XOF)',
            'Date paiement',
            'Statut',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->receipt_number,
            $payment->reference_wave,
            strtoupper($payment->user->nom) . ' ' . $payment->user->prenom,
            $payment->user->telephone,
            $payment->amount,
            $payment->paid_at?->format('d/m/Y H:i') ?? '—',
            'Confirmé',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD4A843']],
            ],
        ];
    }
    }