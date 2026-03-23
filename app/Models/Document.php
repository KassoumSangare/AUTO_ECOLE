<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'path',
        'original_name',
        'mime_type',
        'size',
        'status',
        'commentaire_admin',
    ];

    // ───────────────────────────────────────────
    // CONSTANTES
    // ───────────────────────────────────────────

    const TYPES = ['cni', 'photo', 'certificat'];
    const STATUSES = ['en_attente', 'valide', 'rejete'];

    const LABELS_TYPE = [
        'cni'        => "Carte Nationale d'Identité",
        'photo'      => 'Photo d\'identité',
        'certificat' => 'Certificat médical',
    ];

    // ───────────────────────────────────────────
    // ACCESSEURS
    // ───────────────────────────────────────────

    /**
     * URL publique signée pour accéder au document (sécurisé).
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk('private')->temporaryUrl($this->path, now()->addMinutes(30));
    }

    public function getLabelTypeAttribute(): string
    {
        return self::LABELS_TYPE[$this->type] ?? $this->type;
    }

    public function getSizeFormatteAttribute(): string
    {
        $kb = round($this->size / 1024, 1);
        return $kb > 1024 ? round($kb / 1024, 2) . ' Mo' : "{$kb} Ko";
    }

    // ───────────────────────────────────────────
    // SCOPES
    // ───────────────────────────────────────────

    public function scopeEnAttente($query)
    {
        return $query->where('status', 'en_attente');
    }

    public function scopeValides($query)
    {
        return $query->where('status', 'valide');
    }

    // ───────────────────────────────────────────
    // RELATIONS
    // ───────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
