<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;

class RoleAndPermissionController extends Controller
{
    public function getRoles(): JsonResponse {

        $roles = Role::with(['users','permissions'])->withCount(['users','permissions'])->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $roles
        ]);

    }

    public function getPermissions(): JsonResponse {

        $permissions = Permission::with(['users','roles'])->withCount(['users','roles'])->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $permissions
        ]);

    }

    public function getWithoutPermissions($id): JsonResponse {

        $role = Role::with(['permissions'])->find($id);
        $allPermissions = Permission::get();
        $permissions = [];

        foreach ($allPermissions as $chv => $vlr) {
            $perm = true;
            foreach ($role->permissions as $item) {
                if ($vlr['name'] == $item['name']) {
                    $perm = false;
                }
            }

            if ($perm) {
                $permissions[$chv] = $vlr;
            }
        }

        $permissions = array_values($permissions);

        return response()->json([
            "data" => [
                'avaliablePermissions'  => $permissions,
                'currentPermissions'    => $role->permissions
            ]
        ]);

    }

    public function getRole($id): JsonResponse {

        $role = Role::find($id);

        return response()->json([
            "data" => $role
        ]);

    }

    public function getPermission($id): JsonResponse {

        $permission = Permission::find($id);

        return response()->json([
            "data" => $permission
        ]);

    }

    public function createRole(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $role = Role::create([
                'name'  => $request->name,
                'guard_name' => 'api',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($request->permissions as $vlr) {
                Permission::find($vlr['id'])->assignRole($role);
            }

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Inclusão de regra',
                'content'   => 'A regra '.$role->name.' foi criada com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Regra criada com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function addUserRole(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $user = User::find($request->user_id);
            $role = Role::find($request->role_id);
            $role->users()->attach($user);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Inclusão de usuário à regra',
                'content'   => 'O usuário '.$user->name.' foi adicionado à regra '.$role->name.' com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Usuário adicionado à regra com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function deleteUserRole($role, $id): JsonResponse {
        try {
            DB::beginTransaction();

            $user = User::find($id);
            $role = Role::find($role);
            $role->users()->detach($user);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Remoção de usuário à regra',
                'content'   => 'O usuário '.$user->name.' foi removido da regra '.$role->name.' com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Usuário removido da regra com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function updateRole(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $role = Role::find($request->id);

            $permissions = [];
            foreach ($request->permissions as $vlr) {
                array_push($permissions,Permission::find($vlr['id']));
            }
            $role->syncPermissions($permissions);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Atualização de regra',
                'content'   => 'A regra '.$role->name.' foi atualizada com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Regra atualizada com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function deleteRole($id): JsonResponse {
        try {
            DB::beginTransaction();

            $role = Role::find($id);
            $role->delete();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Exclusão de regra',
                'content'   => 'A regra '.$role->name.' foi excluída com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Regra deletada com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function addUserPermission(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $user = User::find($request->user_id);
            $permission = Permission::find($request->permission_id);
            $permission->users()->attach($user);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Inclusão de usuário à permissão',
                'content'   => 'O usuário '.$user->name.' foi adicionado à permissão '.$permission->name.' com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Usuário adicionado à permissão com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function removeUserPermission($permission, $id): JsonResponse {
        try {
            DB::beginTransaction();

            $user = User::find($id);
            $permission = Permission::find($permission);
            $permission->users()->detach($user);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Remoção de usuário da permissão',
                'content'   => 'O usuário '.$user->name.' foi removido da permissão '.$permission->name.' com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Usuário removido da permissão com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
