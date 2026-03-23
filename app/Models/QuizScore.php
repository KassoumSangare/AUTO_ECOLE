<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizScore extends Model
{
    use HasFactory;

    protected $table = 'quiz_scores';

    protected $fillable = [
        'user_id',
        'category',
        'score',
        'total_questions',
        'duration_seconds',
    ];

    protected function casts(): array
    {
        return [
            'percentage'       => 'decimal:2',
            'duration_seconds' => 'integer',
        ];
    }

    // ───────────────────────────────────────────
    // CONSTANTES
    // ───────────────────────────────────────────

    const CATEGORY_CODE     = 'code';
    const CATEGORY_CONDUITE = 'conduite';
    const SEUIL_REUSSITE    = 80.00; // 80% pour valider

    // ───────────────────────────────────────────
    // ACCESSEURS
    // ───────────────────────────────────────────

    /**
     * L'élève a-t-il réussi ce quiz ?
     */
    public function getIsReussiAttribute(): bool
    {
        return $this->percentage >= self::SEUIL_REUSSITE;
    }

    /**
     * Durée lisible : "4 min 32 s"
     */
    public function getDureeFormatteeAttribute(): ?string
    {
        if (! $this->duration_seconds) return null;
        $min = intdiv($this->duration_seconds, 60);
        $sec = $this->duration_seconds % 60;
        return "{$min} min {$sec} s";
    }

    // ───────────────────────────────────────────
    // SCOPES
    // ───────────────────────────────────────────

    public function scopeCode($query)
    {
        return $query->where('category', self::CATEGORY_CODE);
    }

    public function scopeConduite($query)
    {
        return $query->where('category', self::CATEGORY_CONDUITE);
    }

    public function scopeReussis($query)
    {
        return $query->where('percentage', '>=', self::SEUIL_REUSSITE);
    }

    // ───────────────────────────────────────────
    // RELATIONS
    // ───────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
