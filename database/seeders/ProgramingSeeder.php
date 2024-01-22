<?php

namespace Database\Seeders;

use App\Models\Programing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $programing = Programing::create([
                'name' => fake()->name(),
                'exercise_year_id' => 1,
                'county_id' => 1,
                'created_at'=> now(),
                'updated_at'=> now()
            ]);
        }

        for ($i = 0; $i < 50; $i++) {
            $programing = Programing::create([
                'name' => fake()->name(),
                'exercise_year_id' => 1,
                'county_id' => rand(2,142),
                'created_at'=> now(),
                'updated_at'=> now()
            ]);
        }
    }
}
