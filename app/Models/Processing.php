<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Types;

class Processing extends Model
{
    use Types;

    protected $table = 'product_on_process';
    protected $fillable  = [
        'image_path',
        'userId',
        'variation_id',
        'description',
        'gender',
        'size',
        'price',
        'productStatus',
        'quantity',
        'total',
        'created_at'
    ];

    use HasFactory;
    
}

