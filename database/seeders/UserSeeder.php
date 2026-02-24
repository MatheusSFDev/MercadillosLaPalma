<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    $Users = [ 
        [
            'name' => 'Generic',
            'surname' => 'Lopez',
            'address' => 'Avenida Siempre Viva 456',
            'phone_number' => '987654321',
            'email' => 'generic@example.com',
            'password' => 'password'
        ], 
        [
            'name' => 'Customer',
            'surname' => 'Lopez',
            'address' => 'Avenida Siempre Viva 456',
            'phone_number' => '987654321',
            'email' => 'customer@example.com',
            'password' => 'password'
        ],
        [
            'name' => 'Seller',
            'surname' => 'Perez',
            'address' => 'Calle Real 789',
            'phone_number' => '555555555',
            'email' => 'seller@example.com',
            'password' => 'password'
        ],
        [
            'name' => 'Admin',
            'surname' => 'Gimenez',
            'address' => 'Calle Falsa 123',
            'phone_number' => '123456789',
            'email' => 'admin@example.com',
            'password' => 'password'
        ],
        [
            'name' => 'Root',
            'surname' => 'Perez',
            'address' => 'Calle Real 789',
            'phone_number' => '555555555',
            'email' => 'root@example.com',
            'password' => 'password'
        ], 
    ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'surname' => $data['surname'],
                    'address' => $data['address'],
                    'phone_number' => $data['phone_number'],
                    'password' => Hash::make($data['password']),
                ]
            );

            $user->assignRole($data['role']);
        }
    }

    $userGeneric = User::find(2);
    $userGeneric->roles()->attach(
        Role::where('name', 'customer')->first()->id
    );

    $userCustomer = User::find(3);
    $userCustomer->roles()->attach(
        Role::where('name', 'seller')->first()->id
    );

    $userSeller = User::find(4);
    $userSeller->roles()->attach(
        Role::where('name', 'admin')->first()->id
    );

    $userRoot = User::find(5);
    $userRoot->roles()->attach(
        Role::where('name', 'root')->first()->id
    );
    }
}