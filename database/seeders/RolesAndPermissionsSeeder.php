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

            $super_admin = Role::create([
                'name'  => 'super admin',
                'guard_name' => 'api',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $permissions = [
                'usuario listar',
                'usuario criar',
                'usuario atualizar',
                'usuario detalhar',
                'usuario apagar',
            ];

            foreach($permissions as $vlr) {
                $permission = Permission::create([
                    'name'  => $vlr,
                    'guard_name' => 'api',
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->assignRole($super_admin);
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
        }

    }
}
