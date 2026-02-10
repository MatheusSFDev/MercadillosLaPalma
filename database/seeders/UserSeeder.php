<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    $Users = [
        [
            'name' => 'Paco',
            'surname' => 'Gimenez',
            'address' => 'Calle Falsa 123',
            'number' => '123456789',
            'email' => 'paco@example.com',
            'password' => 'password'
        ],
        [
            'name' => 'Maria',
            'surname' => 'Lopez',
            'address' => 'Avenida Siempre Viva 456',
            'number' => '987654321',
            'email' => 'maria@example.com',
            'password' => 'password'
        ],
        [
            'name' => 'Juan',
            'surname' => 'Perez',
            'address' => 'Calle Real 789',
            'number' => '555555555',
            'email' => 'juan@example.com',
            'password' => 'password'
        ]
    ];

    foreach ($Users as $user) {
        DB::table('users')->insert([
            'name' => $user['name'],
            'surname' => $user['surname'],
            'address' => $user['address'],
            'number' => $user['number'],
            'email' => $user['email'],
            'password' => $user['password'],
        ]);
    }
}
}