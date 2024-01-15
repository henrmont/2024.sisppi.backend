<?php

namespace Database\Seeders;

use App\Models\Favorite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('favorites')->insert(
            [
                [
                    'user_id'   => 1,
                    'link_id'   => 3,
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'user_id'   => 1,
                    'link_id'   => 4,
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'user_id'   => 1,
                    'link_id'   => 5,
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'user_id'   => 1,
                    'link_id'   => 6,
                    'created_at'=> now(),
                    'updated_at'=> now()
                ]
            ]
        );
    }
}
