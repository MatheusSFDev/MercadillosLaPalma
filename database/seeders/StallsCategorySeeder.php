<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StallsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stallsCategories = [
            ['stall_id' => 1, 'category_id' => 1],
            ['stall_id' => 1, 'category_id' => 2],
            ['stall_id' => 2, 'category_id' => 3],
            ['stall_id' => 2, 'category_id' => 4],
        ];

        foreach ($stallsCategories as $stallCategory) {
            DB::table('stalls_category')->insert(
                [
                    'stall_id' => $stallCategory['stall_id'],
                    'category_id' => $stallCategory['category_id'],
                ]
            );
        }
    }
}
