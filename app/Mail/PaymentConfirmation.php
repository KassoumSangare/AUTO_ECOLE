<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    /**
     * Définir l'enveloppe du mail
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: "Confirmation de paiement - Commande #{$this->order->id}",
        );
    }

    /**
     * Définir le contenu du mail
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-confirmation',
            with: [
                'order' => $this->order,
                'user' => $this->order->user,
            ],
        );
    }

    /**
     * Joindre les fichiers
     */
    public function attachments(): array
    {
        $attachments = [];

        // Joindre le reçu PDF s'il existe
        $receiptPath = "receipts/receipt-{$this->order->id}.pdf";
        if (Storage::disk('local')->exists($receiptPath)) {
            $attachments[] = Attachment::fromStorage('local', $receiptPath)
                ->as("Receipt-{$this->order->id}.pdf")
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
