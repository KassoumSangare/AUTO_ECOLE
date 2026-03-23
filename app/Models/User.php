<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Champs en masse assignable.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * Champs cachés pour la sérialisation (JSON/API).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed', // Auto-bcrypt Laravel 11
            'is_active'         => 'boolean',
        ];
    }

    // ───────────────────────────────────────────
    // ACCESSEURS
    // ───────────────────────────────────────────

    /**
     * Nom complet : "Koné Mamadou"
     */
    public function getNomCompletAttribute(): string
    {
        return "{$this->nom} {$this->prenom}";
    }

    // ───────────────────────────────────────────
    // SCOPES
    // ───────────────────────────────────────────

    public function scopeEleves($query)
    {
        return $query->where('role', 'eleve');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActifs($query)
    {
        return $query->where('is_active', true);
    }

    // ───────────────────────────────────────────
    // HELPERS ROLE
    // ───────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEleve(): bool
    {
        return $this->role === 'eleve';
    }

    /**
     * Vérifie si l'élève a effectué un paiement complété.
     */
    public function hasPaid(): bool
    {
        return $this->payments()->where('status', 'completed')->exists();
    }

    // ───────────────────────────────────────────
    // RELATIONS ELOQUENT
    // ───────────────────────────────────────────

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function quizScores(): HasMany
    {
        return $this->hasMany(QuizScore::class);
    }
}
