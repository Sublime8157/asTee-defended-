<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnHand extends Model
{
    protected $table = 'onhand';
    protected $fillable  = [
        'image_path',
        'variation',
        'description',
        'gender',
        'size',
        'price',
        'quantity',
    ];

    use HasFactory;
}
