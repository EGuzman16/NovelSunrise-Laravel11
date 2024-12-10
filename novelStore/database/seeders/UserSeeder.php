<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => \Hash::make('123456'),
            'role' => 'Admin', // Rol de administrador
        ]);

        // Usuario Común
        User::create([
            'name' => 'Common User',
            'email' => 'common@test.com',
            'password' => \Hash::make('123456'),
            'role' => 'Common', // Rol de usuario común
        ]);
    }
}