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
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@ruaya.space',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Staff',
            'email' => 'staff@ruaya.space',
            'password' => bcrypt('staff123'),
            'role' => 'staff',
        ]);
    }
}
