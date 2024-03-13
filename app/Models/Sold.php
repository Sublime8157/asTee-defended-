<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    protected $table = 'sold';
    protected $fillable = [
        'id',
        'productId',
        'userId',
        'amount',
        'quantity',
        'created_at'
    ];
    use HasFactory;

    
}
