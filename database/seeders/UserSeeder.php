<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => fake()->name(),
                'cell_phone' =>'65999520849',
                'phone' => '6530255588',
                'cpf'   => '00000000000',
                'county_id' => fake()->randomElement([null,rand(1,142)]),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'password' => Hash::make('123456'),
            ]);
        }
    }
}
