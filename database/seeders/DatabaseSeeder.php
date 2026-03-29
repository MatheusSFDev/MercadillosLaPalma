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
            RoleSeeder::class,
            PermisionSeeder::class,
            Role_Has_PermisionSeeder::class,
            CategoriesSeeder::class,
            UserSeeder::class,
            MunicipalitiesSeeder::class,
            FleaMarketSeeder::class,
            ScheduleSeeder::class,
            HolydaysSeeder::class,
            AdministratorSeeder::class,
            PaymentMethodSeeder::class,
            StallsSeeders::class,
            StallsCategorySeeder::class,
            PaymentMethodStallSeeder::class,
            ProductSeeder::class,
            PhotosSeeder::class,
            ProductStallSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class,
        ]);
    }
}
