<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if admin already exists before creating
        if (!\App\Models\User::where('email', 'admin@ruaya.space')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@ruaya.space',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]);
        }

        // Check if kasir 1 already exists before creating
        if (!\App\Models\User::where('email', 'kasir1@ruaya.space')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'Kasir A',
                'email' => 'kasir1@ruaya.space',
                'password' => bcrypt('kasirruaya'),
                'role' => 'kasir',
            ]);
        }

        // Check if kasir 2 already exists before creating
        if (!\App\Models\User::where('email', 'kasir2@ruaya.space')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'Kasir B',
                'email' => 'kasir2@ruaya.space',
                'password' => bcrypt('kasirruaya'),
                'role' => 'kasir',
            ]);
        }
    }
}
