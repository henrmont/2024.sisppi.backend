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
                    'name'   => '01/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '02/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '03/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '04/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '05/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '06/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '07/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '08/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '09/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '10/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '11/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'   => '12/2024',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ]
            ]
        );
    }
}
