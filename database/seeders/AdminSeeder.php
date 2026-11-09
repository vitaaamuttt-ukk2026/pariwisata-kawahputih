<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kawahputih.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'pengelola@kawahputih.test'],
            [
                'name' => 'Pengelola Gerbang',
                'password' => Hash::make('pengelola123'),
                'role' => 'pengelola',
            ]
        );
    }
}