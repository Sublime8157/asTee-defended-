<?php

namespace App\Models;

use App\Enums\CancelReason;
use App\Enums\Gender;
use App\Enums\OrderStatus;
use App\Enums\ShirtSize;
use App\Enums\Variation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * One ordered line for its whole life. Replaces the Processing, CancelReturn
 * and Sales models — those were the same line in three tables, moved by a
 * create() plus a delete() with no transaction between them.
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'description',
        'image_path',
        'variation',
        'gender',
        'size',
        'unit_price',
        'quantity',
        'line_total',
        'status',
        'cancel_reason',
        'cancel_note',
    ];

    protected function casts(): array
    {
        return [
            'variation' => Variation::class,
            'gender' => Gender::class,
            'size' => ShirtSize::class,
            'status' => OrderStatus::class,
            'cancel_reason' => CancelReason::class,
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /** Null once the catalog product is deleted; the snapshot columns remain. */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function scopeWithStatus(Builder $query, OrderStatus $status): Builder
    {
        return $query->where('status', $status);
    }
}
