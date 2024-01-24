<?php

namespace Database\Seeders;

use App\Models\Incentive;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncentiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $incentive = Incentive::create([
                'date' => now(),
                'name' => fake()->name(),
                'number' => '123456',
                'value' => rand(100000,900000),
                'type' => fake()->randomElement(['acrescimo','decrescimo']),
                'observation' => fake()->paragraph(),
                'exercise_year_id' => 1,
                'competence_id' => 1,
            ]);
        }
    }
}
