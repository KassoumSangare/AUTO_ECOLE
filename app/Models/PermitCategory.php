<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'online_discount_percent',
        'is_active',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'online_discount_percent' => 'decimal:2',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Scope pour récupérer uniquement les catégories actives.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour trier par ordre d'affichage.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }

    /**
     * Calcule le prix après réduction en ligne.
     *
     * @return float
     */
    public function getDiscountedPriceAttribute(): float
    {
        $discount = ($this->price * $this->online_discount_percent) / 100;
        return $this->price - $discount;
    }

    /**
     * Retourne le montant de la réduction.
     *
     * @return float
     */
    public function getDiscountAmountAttribute(): float
    {
        return ($this->price * $this->online_discount_percent) / 100;
    }

    /**
     * Formate le prix pour l'affichage.
     *
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', ' ') . ' XOF';
    }

    /**
     * Formate le prix réduit pour l'affichage.
     *
     * @return string
     */
    public function getFormattedDiscountedPriceAttribute(): string
    {
        return number_format($this->discounted_price, 0, ',', ' ') . ' XOF';
    }
}