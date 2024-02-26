<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class statusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
}
