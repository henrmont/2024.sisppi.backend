<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $arrayOfPermissionNames = [
            'usuario listar',
            'usuario criar',
            'usuario atualizar',
            'usuario detalhar',
            'usuario apagar',
        ];

        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return [
                'name' => $permission,
                'guard_name' => 'api',
                'created_at' => now(),
                'updated_at' => now()
            ];
        });

        Permission::insert($permissions->toArray());

        Role::create(['name' => 'Super Admin']);

        $user = Role::create(['name' => 'usuario']);


        // $user->givePermissionTo(Permission::whereNot('name','like','usuario%')->get());
        $user->givePermissionTo(Permission::where('name','Super Admin')->get());
    }
}
