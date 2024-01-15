<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('competencies')->insert(
            [
                [
                    'competence'   => '01/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '02/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '03/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '04/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '05/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '06/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '07/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '08/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '09/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '10/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '11/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'competence'   => '12/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ]
            ]
        );
    }
}
