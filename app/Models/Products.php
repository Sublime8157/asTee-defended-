<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variations;
use App\Traits\Types;

class Products extends Model
{
    use Types, HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'userId',
        'image_path',
        'description',
        'price',
        'quantity',
        'created_at'
    ];    
}