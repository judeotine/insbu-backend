<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Main database seeder for the INSBU Statistics Portal
 * Seeds the database with sample data for development and testing
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            NewsSeeder::class,
            DocumentSeeder::class,
        ]);
    }
}
