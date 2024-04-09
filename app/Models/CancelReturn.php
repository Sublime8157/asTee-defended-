<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Types;

class CancelReturn extends Model
{

    use Types;

    protected $table = 'product_on_return_cancel';
    protected $fillable = [
        'id',
        'userId',
        'image_path',
        'variation_id',
        'description',
        'reason',
        'specify',
        'gender',
        'size',
        'price',
        'quantity',
        'total'
    ];
    use HasFactory;
}
