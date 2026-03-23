<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference_wave',
        'wave_checkout_id',
        'amount',
        'currency',
        'status',
        'receipt_path',
        'receipt_number',
        'wave_payload',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'       => 'decimal:2',
            'wave_payload' => 'array',   // JSON auto-encodé/décodé
            'paid_at'      => 'datetime',
        ];
    }

    // ───────────────────────────────────────────
    // CONSTANTES
    // ───────────────────────────────────────────

    const STATUS_PENDING   = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED    = 'failed';
    const STATUS_REFUNDED  = 'refunded';

    // ───────────────────────────────────────────
    // ACCESSEURS
    // ───────────────────────────────────────────

    public function getMontantFormatteAttribute(): string
    {
        return number_format($this->amount, 0, ',', ' ') . ' ' . $this->currency;
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    // ───────────────────────────────────────────
    // SCOPES
    // ───────────────────────────────────────────

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Génère un numéro de reçu formaté unique : REC-2026-000042
     */
    public static function generateReceiptNumber(): string
    {
        $year  = now()->year;
        $count = static::whereYear('created_at', $year)->count() + 1;
        return sprintf('REC-%s-%06d', $year, $count);
    }

    // ───────────────────────────────────────────
    // RELATIONS
    // ───────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
