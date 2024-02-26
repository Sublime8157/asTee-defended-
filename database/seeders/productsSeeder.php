<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::create([
        'image_path'=>'p3.jpg',
        'variation_id'=> 3,
        'description'=> 'Sample 3',
        'gender' => 3,
        'size' => 3,
        'price'=> 40,
        'quantity'=> 1,
        'status' => 1,
        'productStatus'=>2,
        ]);
    }
}
