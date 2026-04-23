<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{

    use HasFactory;

    protected $fillable = [
        'message',
        'emoji',
        'expires_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope : annonces actives et non expirées
     */
    public function scopeVisible($query)
    {
        return $query->where('is_active', true)
            ->where('expires_at', '>', now());
    }

    /**
     * Vérifie si l'annonce est encore valide
     */
    public function isValid(): bool
    {
        return $this->is_active && $this->expires_at->isFuture();
    } //
}
