<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * User seeder for creating sample users with different roles
 * Creates admin, editor, and regular users for testing
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User - Demo credentials
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin123!'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Editor Users - Demo credentials
        User::create([
            'name' => 'Editor One',
            'email' => 'editor1@example.com',
            'password' => Hash::make('Editor123!'),
            'role' => 'editor',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Editor Two',
            'email' => 'editor2@example.com',
            'password' => Hash::make('Editor123!'),
            'role' => 'editor',
            'is_active' => true,
        ]);

        // Create Regular Users - Demo credentials
        User::create([
            'name' => 'User One',
            'email' => 'user1@example.com',
            'password' => Hash::make('User123!'),
            'role' => 'user',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'User Two',
            'email' => 'user2@example.com',
            'password' => Hash::make('User123!'),
            'role' => 'user',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'User Three',
            'email' => 'user3@example.com',
            'password' => Hash::make('User123!'),
            'role' => 'user',
            'is_active' => true,
        ]);

        // Additional sample users for testing with varied creation dates
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'created_at' => now()->subMonths(2),
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
            'created_at' => now()->subMonths(1),
        ]);

        User::create([
            'name' => 'Sarah Wilson',
            'email' => 'sarah.wilson@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => false,
            'created_at' => now()->subWeeks(3),
        ]);
    }
}
