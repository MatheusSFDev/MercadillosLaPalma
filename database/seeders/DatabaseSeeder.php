<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            MunicipalitiesSeeder::class,
            FleaMarketSeeder::class,
            AdministratorSeeder::class,
            StallsSeeders::class,
            PhotosSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class,
            StockProductSeeder::class
        ]);
    }
}
