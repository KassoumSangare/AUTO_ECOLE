<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'description',
        'status',
        'wave_checkout_id',
        'wave_transaction_id',
        'paid_at',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
        'paid_at' => 'datetime',
    ];

    // ══════════════════════════════════════════════════════
    // RELATIONS
    // ══════════════════════════════════════════════════════

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ══════════════════════════════════════════════════════
    // SCOPES
    // ══════════════════════════════════════════════════════

    public function scopeSucceeded($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // ══════════════════════════════════════════════════════
    // ACCESSORS & MUTATORS
    // ══════════════════════════════════════════════════════

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'completed' => 'Complété',
            'failed' => 'Échoué',
            'processing' => 'En cours',
            default => 'Inconnu',
        };
    }

    // ══════════════════════════════════════════════════════
    // METHODS
    // ══════════════════════════════════════════════════════

    public function markAsCompleted(array $waveData = []): void
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
            'wave_transaction_id' => $waveData['transaction_id'] ?? null,
            'metadata' => array_merge(
                (array) $this->metadata,
                ['wave_data' => $waveData]
            ),
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }

    public static function generateReceiptNumber(): string
    {
        $date = now()->format('Y-m-d');
        $count = static::whereDate('created_at', $date)->count();
        return "RCP-{$date}-" . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}
