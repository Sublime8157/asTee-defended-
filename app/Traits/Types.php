<?php 

namespace App\Traits;

trait Types {
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
                return 'To Review';
            case 5:
                return 'To Cancel';
            default:
                return 'Error Occcur';
        }
    }
    
    public function variationType()
    {  
        switch ($this->variation_id) {
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

    public function reason(){
            switch($this->reason) {
            case 1:
                return 'Wrong Product';
            case 2:
                return 'Different Colors';
            case 3:
                return 'Wrong design';
            case 4:
                return 'Reason 1 ';
            case 5:
                return 'Reason 2';
            case 6:
                return 'Reason 3';
            case 7:
                return 'Reason 4';
        }
    }
}


?>