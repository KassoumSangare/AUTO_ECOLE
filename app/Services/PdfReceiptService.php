<?php

namespace App\Services;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfReceiptService
{
    /**
     * Génère une instance PDF configurée
     */
    private function makePdf(Payment $payment)
    {
        $payment->loadMissing('user');

        return Pdf::loadView('pdf.receipt', ['payment' => $payment])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'dpi' => 150,
            ]);
    }

    /**
     * Nettoie le nom du fichier
     */
    private function getSafeFilename(Payment $payment): string
    {
        $receiptNumber = preg_replace('/[^A-Za-z0-9\-_]/', '', $payment->receipt_number ?? 'recu');
        return $receiptNumber . '.pdf';
    }

    /**
     * Génère et sauvegarde le PDF
     */
    public function generate(Payment $payment): string
    {
        $pdf = $this->makePdf($payment);

        $year = optional($payment->created_at)->year ?? date('Y');
        $filename = $this->getSafeFilename($payment);
        $path = "receipts/{$year}/{$filename}";

        if (!Storage::disk('private')->exists($path)) {
            Storage::disk('private')->put($path, $pdf->output());
        }

        return $path;
    }

    /**
     * Stream (affichage navigateur)
     */
    public function stream(Payment $payment): \Illuminate\Http\Response
    {
        $pdf = $this->makePdf($payment);
        return $pdf->stream($this->getSafeFilename($payment));
    }

    /**
     * Download forcé
     */
    public function download(Payment $payment): \Illuminate\Http\Response
    {
        $pdf = $this->makePdf($payment);
        return $pdf->download($this->getSafeFilename($payment));
    }
}