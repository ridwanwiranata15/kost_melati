<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' =>Hash::make('password'),
                'phone' =>  '085777707854',
                'role' => 'admin',
                'status' => 'active'
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'phone' =>  '085777707854',
                'role' => 'customer',
                'status' => 'active'
            ]
        ];

        User::insert($users);

        $this->call([
            MultiKosSeeder::class,
        ]);
    }
}
