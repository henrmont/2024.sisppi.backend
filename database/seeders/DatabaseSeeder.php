<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Jorge Monteiro',
            'email' => 'jorge@teste.com',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'password' => Hash::make('123456'),
        ]);

        $this->call([
            UserSeeder::class,
            RolesAndPermissionsSeeder::class,
            LinkSeeder::class,
            NotificationSeeder::class,
            FavoriteSeeder::class,
        ]);
    }
}
