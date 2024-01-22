<?php

namespace Database\Seeders;

use App\Models\ProgramingProcedure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramingProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $procedure = ProgramingProcedure::create([
                'programing_id' => 1,
                'procedure_id' => rand(1,4700),
                'created_at'=> now(),
                'updated_at'=> now()
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            $procedure = ProgramingProcedure::create([
                'programing_id' => 2,
                'procedure_id' => rand(1,4700),
                'created_at'=> now(),
                'updated_at'=> now()
            ]);
        }
    }
}
