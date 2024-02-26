<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Variations;

class variationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Variations::insert([
            'type' => 'Couple Shirt',
        ]);
        Variations::insert([
            'type' => 'Solo Shirt',
        ]);
        Variations::insert([
            'type' => 'Family Shirt',
        ]);
        Variations::insert([
            'type' => 'Kids Wear',
        ]);
    }
}
