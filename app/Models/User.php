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

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'password',
        'is_manually_approved',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_manually_approved' => 'boolean',
        ];
    }

    // ───────────────────────────────────────────
    // ACCESSEURS
    // ───────────────────────────────────────────

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
    // HELPERS
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
     * Vérifie si l'utilisateur a un paiement Wave confirmé.
     */
    public function hasPaid(): bool
    {
        return $this->payments()
            ->where('status', 'completed')
            ->exists();
    }

    /**
     * Vérifie l'accès premium :
     * paiement Wave validé OU approbation manuelle par l'admin.
     */
    public function hasPremiumAccess(): bool
    {
        return $this->hasPaid() || $this->is_manually_approved;
    }

    // ───────────────────────────────────────────
    // RELATIONS
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