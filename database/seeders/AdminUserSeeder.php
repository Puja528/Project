<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Pastikan user admin ada
        User::firstOrCreate(
            ['email' => 'admin@fintrack.com'],
            [
                'name' => 'Admin System',
                'password' => Hash::make('password123'),
                'type' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // User standard
        User::firstOrCreate(
            ['email' => 'budi@email.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'type' => 'standard',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'sari@email.com'],
            [
                'name' => 'Sari Dewi',
                'password' => Hash::make('password123'),
                'type' => 'standard',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // User advance
        User::firstOrCreate(
            ['email' => 'ahmad@email.com'],
            [
                'name' => 'Ahmad Rizki',
                'password' => Hash::make('password123'),
                'type' => 'advance',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'maya@email.com'],
            [
                'name' => 'Maya Sari',
                'password' => Hash::make('password123'),
                'type' => 'advance',
                'status' => 'inactive',
                'email_verified_at' => now(),
            ]
        );
    }
}