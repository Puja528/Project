<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@fintrack.com',
            'password' => Hash::make('password123'),
            'type' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Standard users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@email.com',
            'password' => Hash::make('password123'),
            'type' => 'standard',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Sari Dewi',
            'email' => 'sari@email.com',
            'password' => Hash::make('password123'),
            'type' => 'standard',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Advance users
        User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad@email.com',
            'password' => Hash::make('password123'),
            'type' => 'advance',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Maya Sari',
            'email' => 'maya@email.com',
            'password' => Hash::make('password123'),
            'type' => 'advance',
            'status' => 'inactive',
            'email_verified_at' => now(),
        ]);
    }
}