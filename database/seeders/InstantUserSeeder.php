<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstantUserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Hum Chan',
            'email' => 'hum.chan@nubb.edu.kh',
            'password' => Hash::make('humchan123'),
            'role' => 'admin',
            'notifications_enabled' => true,
            'reviewer_available' => true
        ]);

        // Create regular user
        // User::create([
        //     'name' => 'User',
        //     'email' => 'user@example.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'user',
        //     'notifications_enabled' => true,
        //     'reviewer_available' => false
        // ]);
    }
}