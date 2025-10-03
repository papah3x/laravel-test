<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Database\Seeders\PropertySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed demo users
        User::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager',
                'role' => 'manager',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'guest@example.com'],
            [
                'name' => 'Guest',
                'role' => 'client',
                'password' => Hash::make('password'),
            ]
        );

        // Seed demo properties with fetched images
        $this->call(PropertySeeder::class);
    }
}
