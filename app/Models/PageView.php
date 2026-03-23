<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = ['page', 'count'];

    /**
     * Incrémente atomiquement le compteur d'une page.
     * Utilisation : PageView::increment('home');
     */
    public static function hit(string $page = 'home'): int
    {
        $record = static::firstOrCreate(
            ['page'  => $page],
            ['count' => 0]
        );

        // Incrément atomique (thread-safe)
        static::where('page', $page)->increment('count');
        $record->refresh();

        return $record->count;
    }

    /**
     * Retourne le total de vues d'une page.
     */
    public static function getCount(string $page = 'home'): int
    {
        return static::where('page', $page)->value('count') ?? 0;
    }
}
