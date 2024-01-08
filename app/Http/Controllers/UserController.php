<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUsers(): JsonResponse {

        $users = User::orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $users
        ]);

    }

    public function getUser($id): JsonResponse {

        $user = User::find($id);

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
}
