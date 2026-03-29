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
            ['stall_id' => 2, 'category_id' => 3],
            ['stall_id' => 3, 'category_id' => 6],
            ['stall_id' => 4, 'category_id' => 4],
            ['stall_id' => 5, 'category_id' => 2],
            ['stall_id' => 6, 'category_id' => 5],
            ['stall_id' => 7, 'category_id' => 7],
            ['stall_id' => 8, 'category_id' => 8],
            ['stall_id' => 9, 'category_id' => 8],
            ['stall_id' => 10, 'category_id' => 3],
            ['stall_id' => 10, 'category_id' => 8],
            ['stall_id' => 11, 'category_id' => 8],
            ['stall_id' => 12, 'category_id' => 3],
            ['stall_id' => 13, 'category_id' => 4],
            ['stall_id' => 13, 'category_id' => 8],
            ['stall_id' => 14, 'category_id' => 3],
        ];

        foreach ($stallsCategories as $stallCategory) {
            DB::table('category_stall')->insert(
                [
                    'stall_id' => $stallCategory['stall_id'],
                    'category_id' => $stallCategory['category_id'],
                ]
            );
        }
    }
}
