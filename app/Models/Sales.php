<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $fillable = [
        'id',
        'ordersId',
        'userId',
        'amount',
        'created_at'
    ];
    use HasFactory;

    
}
