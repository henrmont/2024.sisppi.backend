<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function getUsers(): JsonResponse {

        $users = User::with(['county'])->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $users
        ]);

    }

    public function getUsersWithoutRole($id): JsonResponse {

        $role = Role::with(['users'])->find($id);
        $allUsers = User::all();
        $users = [];

        foreach ($allUsers as $chv => $vlr) {
            $perm = true;
            foreach ($role->users as $item) {
                if ($vlr['id'] == $item['id']) {
                    $perm = false;
                }
            }

            if ($perm) {
                $users[$chv] = $vlr;
            }
        }

        $users = array_values($users);

        return response()->json([
            "data" => $users
        ]);

    }

    public function getUsersWithoutPermission($id): JsonResponse {

        $permission = Permission::with(['users','roles.users'])->find($id);
        $allUsers = User::all();
        $users = [];

        foreach ($allUsers as $chv => $vlr) {
            $perm = true;
            foreach ($permission->users as $item) {
                if ($vlr['id'] == $item['id']) {
                    $perm = false;
                }
            }

            foreach ($permission->roles as $item) {
                foreach ($item->users as $item_vlr) {
                    if ($item_vlr['id'] == $vlr['id']) {
                        $perm = false;
                    }
                }
            }

            if ($perm) {
                $users[$chv] = $vlr;
            }
        }

        $users = array_values($users);

        return response()->json([
            "data" => $users
        ]);

    }

    public function getUser($id): JsonResponse {

        $user = User::with(['county'])->find($id);

        return response()->json([
            "data" => $user
        ]);

    }

    public function getEmptyManagerUsers(): JsonResponse {

        $users = User::where('county_id',null)->get();

        return response()->json([
            "data" => $users
        ]);

    }

    public function changeEmptyManagerUser($id): JsonResponse {
        try {
            DB::beginTransaction();

            $user = User::with(['county'])->find($id);

            $user->county_id = null;

            $user->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Exclusão de gestor.',
                'content'   => 'O gestor '.$user->name.' foi removido com sucesso da gestão do município '.$user->county->name.'.',
            ]);

            Notification::create([
                'user_id'   => $id,
                'title' => 'Gestor excluído.',
                'content'   => 'Você foi removido da gestão do município '.$user->county->name.'.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Gestor excluído com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function changeNoEmptyManagerUser(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $user = User::find($request->user_id);

            $user->county_id = $request->county_id;

            $user->save();

            $user = User::with(['county'])->find($request->user_id);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Adição de gestor.',
                'content'   => 'O gestor '.$user->name.' foi adicionado com sucesso à gestão do município '.$user->county->name.'.',
            ]);

            Notification::create([
                'user_id'   => $request->user_id,
                'title' => 'Gestor adicionado.',
                'content'   => 'Você foi adicionado à gestão do município '.$user->county->name.'.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Gestor adicionado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function createUser(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $user = User::create([
                'email'  => $request->email,
                'name'  => $request->name,
                'password'    => $request->password,
                'cpf'  => $request->cpf,
                'phone'    => $request->phone,
                'cell_phone' => $request->cell_phone,
                'county_id'    => $request->county_id,
                'is_valid'   => $request->is_valid,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Inclusão de usuário',
                'content'   => 'O usuário '.$user->name.' foi criado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Usuário criado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function updateUser(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $user = User::find($request->id);

            $user->email = $request->email;
            $user->name = $request->name;
            $user->cpf = $request->cpf;
            $user->phone = $request->phone;
            $user->cell_phone = $request->cell_phone;
            $user->county_id = $request->county_id;
            $user->is_valid = $request->is_valid;
            $user->updated_at = now();

            $user->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Atualização de usuário',
                'content'   => 'O usuário '.$user->name.' foi atualizado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Usuário atualizado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function deleteUser($id): JsonResponse {
        try {
            DB::beginTransaction();

            $user = User::find($id);
            $user->delete();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Exclusão de usuário',
                'content'   => 'O usuário '.$user->name.' foi excluído com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Usuário deletado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
