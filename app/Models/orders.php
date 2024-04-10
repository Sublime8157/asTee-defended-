<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'userId',
        'productId',
        'address',
        'contact',
        'mop'
    ];
    use HasFactory;
}
