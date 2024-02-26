<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sizes;

class sizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
}
