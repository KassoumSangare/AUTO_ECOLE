<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'image_path',
        'is_active',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function categoryLabels(): array
    {
        return [
            'seance' => 'Séance de conduite',
            'moniteur' => 'Moniteurs',
            'voiture' => 'Voitures',
            'autre' => 'Autre',
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::categoryLabels()[$this->category] ?? $this->category;
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . ltrim($this->image_path, '/'));
    }
}