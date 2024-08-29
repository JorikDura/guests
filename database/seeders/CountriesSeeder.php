<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::json('public/countries.json');

        Country::insert($json);
    }
}
