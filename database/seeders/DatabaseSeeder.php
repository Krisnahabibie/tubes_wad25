<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'manager cafe',
            'email' => 'manager@cafe.com',
            'password' => Hash::make('managertelyucoffe'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'admin cafe',
            'email' => 'admin@cafe.com',
            'password' => Hash::make('admintelyucoffe'),
            'role' => 'admin',
        ]);
    }
}
