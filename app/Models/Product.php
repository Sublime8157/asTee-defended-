<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\ShirtSize;
use App\Enums\Variation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    /**
     * Uploads are stored with a hashed name under `images/` on the public
     * disk, so the stored value already carries its directory. The views used
     * to concatenate 'storage/images/' onto a bare filename.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image_path
            ? Storage::disk('public')->url($this->image_path)
            : asset('images/placeholder.png'));
    }

    /** The listing pages truncate this; it was done in four controllers. */
    protected function shortDescription(): Attribute
    {
        return Attribute::get(fn () => Str::words($this->description, 10));
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
