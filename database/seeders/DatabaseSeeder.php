<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // User admin
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@fintrack.com',
            'password' => Hash::make('password123'),
            'type' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // User standard
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@email.com',
            'password' => Hash::make('password123'),
            'type' => 'standard',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // User advance
        User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad@email.com',
            'password' => Hash::make('password123'),
            'type' => 'advance',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
