<?php

namespace Database\Seeders;

use App\Models\ExerciseYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exercise_year = ExerciseYear::create([
            'name' => 2023,
            'created_at'=> now(),
            'updated_at'=> now()
        ]);

        $exercise_year = ExerciseYear::create([
            'name' => 2024,
            'created_at'=> now(),
            'updated_at'=> now()
        ]);
    }
}
