<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'id',
        'userId',
        'address',
        'productId',
        'contact',
        'mop',
        'paid',
        'created_at'
    ];
    protected $casts = [
        'productId' => 'array',
    ];

    use HasFactory;

    
}
