<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permision=[
        [
            'name'=>'Create',
            'guard_name'=>'web',
        ], 
        [
            'name'=>'Read',
            'guard_name'=>'web',
        ], 
        [
            'name'=>'Update',
            'guard_name'=>'web',
        ], 
        [
            'name'=>'Delete',
            'guard_name'=>'web',
        ]];
        foreach ($permision as $perm) {
            DB::table('permissions')->insert(
                [
                    'name' => $perm['name'],
                    'guard_name' => $perm['guard_name'],
                ]
            );
        }
    }
}
