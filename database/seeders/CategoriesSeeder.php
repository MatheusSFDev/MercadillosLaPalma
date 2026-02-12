<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Categories = [
            'Carniceria',
            'Pescaderia',
            'Verduleria',
            'Artesania',
            'Otros'
        ];

        foreach ($Categories as $Category) {
            DB::table('categories')->insert([
                'name' => $Category,
            ]);
        }
    }
}
