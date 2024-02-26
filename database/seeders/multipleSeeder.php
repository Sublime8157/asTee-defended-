<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genders;
use App\Models\productStatus;
use App\Models\Sizes;
use App\Models\Status;
use App\Models\Variations;

class multipleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void {
        $this->productStatus();
        // $this->genders();
        // $this->sizes();
        // $this->variations();
        // $this->status();
    }

    private function productStatus() {
        productStatus::insert([
            'product_status_id' => 1,
            'status' => 'To Pay'
        ]);
        productStatus::insert([
            'product_status_id' => 2,
            'status' => 'To Ship'
        ]);
        productStatus::insert([
            'product_status_id' => 3,
            'status' => 'To Recieve'
        ]);
        productStatus::insert([
            'product_status_id' => 4,
            'status' => 'To Feedback'
        ]);

     }
     private function genders()
    {
        Genders::insert([
            'gender_id' => 1,
            'gender' => 'Male',
        ]);
        Genders::insert([
            'gender_id' => 2,
            'gender' => 'FeMale',
        ]);
        Genders::insert([
            'gender_id' => 3,
            'gender' => 'Unisex',
        ]);
    }

    private function sizes()
    {
        Sizes::insert([
            'size_id' => 1,
            'size' => 'XS',
        ]);
        Sizes::insert([
            'size_id' => 2,
            'size' => 'Small',
        ]);
        Sizes::insert([
            'size_id' => 3,
            'size' => 'Medium',
        ]);
        Sizes::insert([
            'size_id' => 4,
            'size' => 'Large',
        ]);
        Sizes::insert([
            'size_id' => 5,
            'size' => 'XL',
        ]);
        Sizes::insert([
            'size_id' => 6,
            'size' => 'XXL',
        ]);
    }

    private function status()
    {
        Status::insert([
            'status_id' => 1,
            'status' => 'On Hand'
        ]);
        Status::insert([
            'status_id' => 2,
            'status' => 'On Process'
        ]);
        Status::insert([
            'status_id' => 3,
            'status' => 'On Cancel_Return'
        ]);
    }

    private function variations()
    {
        Variations::insert([
            'variation_id' => 1,
            'variation' => 'Couple Shirt',
        ]);
        Variations::insert([
            'variation_id' => 2,
            'variation' => 'Solo Shirt',
        ]);
        Variations::insert([
            'variation_id' => 3,
            'variation' => 'Family Shirt',
        ]);
        Variations::insert([
            'variation_id' => 4,
            'variation' => 'Kids Wear',
        ]);
    }

}
