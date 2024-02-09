<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Product::factory()->create([
            'name' => 'Paket 1',
            'price' => 150000,
        ]);

        Product::factory()->create([
            'name' => 'Paket 2',
            'price' => 200000,
        ]);
        Product::factory()->create([
            'name' => 'Paket 3',
            'price' => 250000,
        ]);
    }
}
