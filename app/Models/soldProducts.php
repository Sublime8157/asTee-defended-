<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class soldProducts extends Model
{
    protected $table = "product_sold";
    protected $fillable = [
        'userId',
        'amount',
        'quantity'
    ];
    use HasFactory;
}
