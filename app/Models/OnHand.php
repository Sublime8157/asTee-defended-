<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Types;

class OnHand extends Model
{
    use Types, HasFactory;

    protected $table = 'product_on_hand';
    protected $fillable  = [
        'image_path',
        'variation_id',
        'description',
        'gender',
        'size',
        'price',
        'quantity'
    ];

    
    
}

