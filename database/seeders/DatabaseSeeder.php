<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('testing123'),
        ]);

        // 3 categories
        \App\Models\Category::factory(3)->create();

        // 3 subcategories - use for loop for rand isn't always the same
        for($i = 0; $i < 3; $i++) {
            \App\Models\Category::factory()->create([
                'parent_id' => rand(1, 3),
            ]);
        }

        // 3 locations
        \App\Models\Location::factory(3)->create();

        // 3 sublocations
        for($i = 0; $i < 3; $i++) {
            \App\Models\Location::factory()->create([
                'parent_id' => rand(1, 3),
            ]);
        }

        // 10 assets
        for($i = 0; $i < 10; $i++) {
            \App\Models\Asset::factory()->create([
                'category_id' => rand(1, 6),
                'location_id' => rand(1, 6),
            ]);
        }
    }
}
