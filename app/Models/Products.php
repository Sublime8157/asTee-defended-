<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variations;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'image_path',
        'variation',
        'description',
        'gender',
        'size',
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

    public function producStats() {
        switch ($this->productStatus) {
            case 0:
                return 'On Hand';
            case 1:
                return 'To Pay';
            case 2:
                return 'To Ship';
            case 3:
                return 'To Recieve';
            case 4:
                return 'Feedback';
            default:
                return 'Error Occcur';
        }
    }
    public function variationType()
    {  
        switch ($this->variation) {
            case 1:
                return 'Couple Shirt';
            case 2:
                return 'Solo Shirt';
            case 3:
                return 'Family Shirt';
            case 4:
                return 'Kids Wear';
            default:
                return 'Unknown';
        }
    }

    // Same logic on variation and variationType funcition

   
    public function sizeShirt(){
        switch($this->size) {
            case 1:
                return 'XS';
            case 2:
                return 'Small';
            case 3:
                return 'Medium';
            case 4:
                return 'Large';
            case 5:
                return 'XL';
            case 6:
                return 'XXL';
            case 7:
                return 'XXL';
        }
    }

    // Same logic on variation and variationType funcition

    
    public function genderShirt() {
       switch($this->gender) {
        case 1:
            return 'Male';
        case 2:
            return 'Female';
        case 3:
            return 'Unisex';
        default:
            return 'Unknown';
       }
    }

    
}