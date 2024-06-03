<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feedback extends Model
{
    protected $table = "feedback";
    protected $fillable = [ 
        "userId",
        "productId",
        "starCountAll",
        "starCountQuality",
        "starCountService",
        "specify",
        "created_at",
        "featured",
        "image"
    ];
    use HasFactory;
}
