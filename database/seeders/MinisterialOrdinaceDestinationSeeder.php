<?php

namespace Database\Seeders;

use App\Models\MinisterialOrdinaceDestination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MinisterialOrdinaceDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $ministerial_ordinace_destination = MinisterialOrdinaceDestination::create([
                'value' => 0,
                'ministerial_ordinace_id' => 1,
                'county_id' => rand(1,142),
            ]);
        }
    }
}
