<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
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
