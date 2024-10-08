<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genders;
use App\Models\productStatus;
use App\Models\Sizes;
use App\Models\Status;
use App\Models\Variations;
use App\Models\UserStatus;


class multipleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void {
        $this->productStatus();
        $this->genders();
        $this->sizes();
        $this->variations();
        $this->status();
        $this->userStatus();
    }
    // populate the productStatus table with these value 
    private function productStatus() {
        productStatus::insert([
            'status' => 'To Pay'
        ]);
        productStatus::insert([            
            'status' => 'To Ship'
        ]);
        productStatus::insert([           
            'status' => 'To Recieve'
        ]);
        productStatus::insert([            
            'status' => 'To Feedback'
        ]);
        productStatus::insert([
            'status' => 'To Cancel'
        ]);
     }

    //  Populate the genders table with these value 
     private function genders()
    {
        Genders::insert([           
            'gender' => 'Male',
        ]);
        Genders::insert([           
            'gender' => 'FeMale',
        ]);
        Genders::insert([            
            'gender' => 'Unisex',
        ]);
    }

    // populate the sized table 
    private function sizes()
    {
        Sizes::insert([            
            'size' => 'XS',
        ]);
        Sizes::insert([            
            'size' => 'Small',
        ]);
        Sizes::insert([          
            'size' => 'Medium',
        ]);
        Sizes::insert([           
            'size' => 'Large',
        ]);
        Sizes::insert([            
            'size' => 'XL',
        ]);
        Sizes::insert([           
            'size' => 'XXL',
        ]);
    }
    // poulate the status table 
    private function status()
    {
        Status::insert([           
            'status' => 'On Hand'
        ]);
        Status::insert([           
            'status' => 'On Process'
        ]);
        Status::insert([            
            'status' => 'On Cancel_Return'
        ]);
    }

    // populate the variations table 
    private function variations()
    {
        Variations::insert([            
            'variation' => 'Couple Shirt',
        ]);
        Variations::insert([            
            'variation' => 'Solo Shirt',
        ]);
        Variations::insert([            
            'variation' => 'Family Shirt',
        ]);
        Variations::insert([           
            'variation' => 'Kids Wear',
        ]);
    }

    private function userStatus() {
        UserStatus::insert([
            'status' => 'active',
            
        ]);
        UserStatus::insert([
            'status' => 'blocked',
        ]);
    }

}
