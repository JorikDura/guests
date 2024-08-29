<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Guest;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Country::factory(3)
            ->has(Guest::factory(5))
            ->create();
    }
}
