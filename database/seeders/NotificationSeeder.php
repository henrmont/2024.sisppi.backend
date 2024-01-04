<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $notification = Notification::create([
                'user_id'   => 1,
                'title'     => fake()->name(),
                'content'   => fake()->paragraph(),
                'created_at'=> now(),
                'updated_at'=> now()
            ]);
        }
    }
}
