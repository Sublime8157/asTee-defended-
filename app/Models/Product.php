<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\ShirtSize;
use App\Enums\Variation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * The catalog. Replaces the OnHand model (`product_on_hand`), which drove both
 * the admin inventory tab and the storefront, and the old Products model, which
 * was a throwaway copy written at review time.
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'description',
        'variation',
        'gender',
        'size',
        'price',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'variation' => Variation::class,
            'gender' => Gender::class,
            'size' => ShirtSize::class,
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }
}
