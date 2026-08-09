<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * A storefront customer. The table is `customers`; `users` was the stock
 * Laravel table and was never used by anything.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'customers';

    protected $fillable = [
        'profile',
        'fname',
        'mname',
        'lname',
        'birthday',
        'email',
        'username',
        'address',
        'contact',
        'password',
        'valid_id_path',
        'blocked_at',
        'id_verified_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'birthday' => 'date',
            'blocked_at' => 'datetime',
            'id_verified_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /** Was `userStatus == 2`. */
    public function isBlocked(): bool
    {
        return $this->blocked_at !== null;
    }

    /** Was `verification == 'verified'` — the admin review of the uploaded ID. */
    public function hasVerifiedId(): bool
    {
        return $this->id_verified_at !== null;
    }

    public function fullName(): string
    {
        return trim("{$this->fname} {$this->lname}");
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('blocked_at');
    }

    public function scopeBlocked(Builder $query): Builder
    {
        return $query->whereNotNull('blocked_at');
    }
}
