<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $super_user = User::create([
            'name' => 'Jorge Monteiro',
            'cell_phone' =>'65999520849',
            'phone' => '6530255588',
            'cpf'   => '80104010215',
            'county_id' => 1,
            'email' => 'jorge@teste.com',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'password' => Hash::make('123456'),
        ]);

        $alt_user = User::create([
            'name' => 'Usuário Teste',
            'cell_phone' =>'65999520849',
            'phone' => '6530255588',
            'cpf'   => '80104010215',
            'county_id' => rand(1,142),
            'email' => 'teste@teste.com',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'password' => Hash::make('123456'),
        ]);

        $this->call([
            UserSeeder::class,
            RolesAndPermissionsSeeder::class,
            LinkSeeder::class,
            NotificationSeeder::class,
            FavoriteSeeder::class,
            CountySeeder::class,
            ExerciseYearSeeder::class,
        ]);

        $role = Role::findByName('admin');
        $role->users()->attach($super_user);
    }
}
