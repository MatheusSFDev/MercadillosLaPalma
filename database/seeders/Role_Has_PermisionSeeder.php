<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Role_Has_PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Role_Has_Permision=[
        [
            'role_id'=>'1',
            'permission_id'=>'1',
        ], 
        [
            'role_id'=>'1',
            'permission_id'=>'2',
        ], 
        [
            'role_id'=>'1',
            'permission_id'=>'3',
        ], 
        [
            'role_id'=>'1',
            'permission_id'=>'4',
        ]];
        foreach ($Role_Has_Permision as $item) {
            DB::table('role_has_permissions')->insert(
                [
                    'role_id' => $item['role_id'],    
                    'permission_id' => $item['permission_id'],
                ]
            );
        }
    }
}
