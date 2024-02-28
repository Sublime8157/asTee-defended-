<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variations;
use App\Traits\Types;

class Products extends Model
{
    use Types;

    protected $table = 'products';
    protected $fillable = [
        'image_path',
        'variation_id',
        'description',
        'gender',
        'size',
        'status',
        'price',
        'quantity',
        'productStatus',
        
    ];

    // variation function created to distiguished the relation between the product table 
    // specifically variation column and variation table specifically id column

    // public function variation(){
    //     return $this->belongsTo(Variations::class, 'variation'); 
    // }   
    // public function gender() {
    //     return $this->belongsTo(Genders::class, 'gender');
    // }
    // public function size(){
    //     return $this->belongsTo(Sizes::class, 'size');
    // }

    // the variationType function posses the switch case that treats the integer from product table (variation column) converted to its real value that based on variation table
    // in other words  the variation column in product table was only a number and those numbers has its value based on the ID of variation column "I really hope you get it" XD


    
}