<?php

namespace Database\Seeders;

use App\Models\IncentiveDestination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncentiveDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $incentive_destination = IncentiveDestination::create([
                'value' => 0,
                'incentive_id' => 1,
                'county_id' => rand(1,142),
            ]);
        }
    }
}
