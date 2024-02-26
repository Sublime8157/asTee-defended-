<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productStatus extends Model
{

    protected $table = 'product_status';
    protected $fillable = [
        'product_status_id',
        'gender',
    ];


    use HasFactory;
}
