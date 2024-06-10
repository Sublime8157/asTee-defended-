<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_history extends Model
{
    use HasFactory;
    protected $table = 'payment_history';
    protected $fillable = [ 
        'id',
        'customers_id',
        'orders_id',
        'bank',
        'amount',
        'proof',
        'created_at'
    ];
}
