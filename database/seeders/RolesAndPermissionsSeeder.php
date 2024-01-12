<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        try {
            DB::beginTransaction();

            $admin = Role::create([
                'name'  => 'admin',
                'guard_name' => 'api',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $permissions = [
                'usuario criar',
                'usuario ver',
                'usuario atualizar',
                'usuario deletar',
                'municipio criar',
                'municipio ver',
                'municipio atualizar',
                'municipio deletar',
                'regra criar',
                'regra ver',
                'regra atualizar',
                'regra deletar',
            ];

            foreach($permissions as $vlr) {
                $permission = Permission::create([
                    'name'  => $vlr,
                    'guard_name' => 'api',
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->assignRole($admin);
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
        }

    }
}
