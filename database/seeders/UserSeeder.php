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
        // Create Admin User
        User::create([
            'name' => 'Dr. Jean-Baptiste Niyonzima',
            'email' => 'admin@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
            'last_login_at' => now()->subHours(2),
            'login_count' => 156,
            'created_at' => now()->subMonths(6),
        ]);

        // Create Editor Users
        User::create([
            'name' => 'Marie Uwimana',
            'email' => 'marie.uwimana@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
            'last_login_at' => now()->subHours(1),
            'login_count' => 89,
            'created_at' => now()->subMonths(4),
        ]);

        User::create([
            'name' => 'Pierre Nkurunziza',
            'email' => 'pierre.nkurunziza@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
            'last_login_at' => now()->subHours(3),
            'login_count' => 67,
            'created_at' => now()->subMonths(3),
        ]);

        // Create Regular Users
        User::create([
            'name' => 'Dr. Aline Bukuru',
            'email' => 'aline.bukuru@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'last_login_at' => now()->subMinutes(30),
            'login_count' => 45,
            'created_at' => now()->subMonths(2),
        ]);

        User::create([
            'name' => 'Janvier Niyongabo',
            'email' => 'janvier.niyongabo@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => false,
            'last_login_at' => now()->subDays(5),
            'login_count' => 23,
            'created_at' => now()->subMonths(1),
        ]);

        User::create([
            'name' => 'Emmanuel Habimana',
            'email' => 'emmanuel.habimana@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'last_login_at' => now()->subMinutes(15),
            'login_count' => 12,
            'created_at' => now()->subWeeks(2),
        ]);

        // Create additional test users
        User::create([
            'name' => 'Solange Ndayishimiye',
            'email' => 'solange.ndayishimiye@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'last_login_at' => now()->subHours(4),
            'login_count' => 31,
            'created_at' => now()->subWeeks(3),
        ]);

        User::create([
            'name' => 'Claude Bizimana',
            'email' => 'claude.bizimana@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
            'last_login_at' => now()->subDays(1),
            'login_count' => 54,
            'created_at' => now()->subMonths(1),
        ]);

        // Demo user for easy testing
        User::create([
            'name' => 'Demo User',
            'email' => 'demo@insbu.bi',
            'password' => Hash::make('demo123'),
            'role' => 'user',
            'is_active' => true,
            'last_login_at' => now()->subMinutes(5),
            'login_count' => 1,
            'created_at' => now(),
        ]);

        // Add more users for better statistics distribution
        User::create([
            'name' => 'Esperance Irakoze',
            'email' => 'esperance.irakoze@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
            'last_login_at' => now()->subHours(8),
            'login_count' => 73,
            'created_at' => now()->subMonths(5)->subDays(10),
        ]);

        User::create([
            'name' => 'Pacifique Nzeyimana',
            'email' => 'pacifique.nzeyimana@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'last_login_at' => now()->subDays(2),
            'login_count' => 28,
            'created_at' => now()->subMonths(1)->subDays(15),
        ]);

        User::create([
            'name' => 'Immaculee Uwimana',
            'email' => 'immaculee.uwimana@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'last_login_at' => now()->subHours(6),
            'login_count' => 42,
            'created_at' => now()->subMonths(2)->subDays(5),
        ]);

        User::create([
            'name' => 'Jean Claude Ndikumana',
            'email' => 'jc.ndikumana@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'last_login_at' => now()->subMinutes(45),
            'login_count' => 18,
            'created_at' => now()->subWeeks(5),
        ]);

        User::create([
            'name' => 'Angelique Nkurunziza',
            'email' => 'angelique.nkurunziza@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => false,
            'last_login_at' => now()->subDays(10),
            'login_count' => 8,
            'created_at' => now()->subMonths(1)->subWeeks(2),
        ]);

        User::create([
            'name' => 'Desire Ntahompagaze',
            'email' => 'desire.ntahompagaze@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
            'last_login_at' => now()->subHours(12),
            'login_count' => 95,
            'created_at' => now()->subMonths(4)->subDays(20),
        ]);

        // Recent users for current month statistics
        User::create([
            'name' => 'Francoise Habonimana',
            'email' => 'francoise.habonimana@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'last_login_at' => now()->subHours(2),
            'login_count' => 5,
            'created_at' => now()->subDays(3),
        ]);

        User::create([
            'name' => 'Thierry Nsabimana',
            'email' => 'thierry.nsabimana@insbu.bi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'last_login_at' => now()->subMinutes(20),
            'login_count' => 2,
            'created_at' => now()->subDays(1),
        ]);
    }
}
