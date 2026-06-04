<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question',
        'options',
        'correct_index',
        'explication',
        'is_active',
    ];

    protected $casts = [
        'options'       => 'array',
        'correct_index' => 'integer',
        'is_active'     => 'boolean',
    ];

    // ── Scopes ───────────────────────────────────────────────

    public function scopeCode($query)
    {
        return $query->where('category', 'code')->where('is_active', true);
    }

    public function scopeConduite($query)
    {
        return $query->where('category', 'conduite')->where('is_active', true);
    }

    // ── Formatage pour l'API JSON ─────────────────────────

    /**
     * On n'expose JAMAIS correct_index dans l'API publique (anti-triche).
     * Il n'est envoyé qu'au moment de la correction côté serveur.
     */
    public function toApiArray(): array
    {
        return [
            'id'          => $this->id,
            'question'    => $this->question,
            'options'     => $this->options,
            'explication' => $this->explication,
            // correct_index volontairement absent
        ];
    }
}