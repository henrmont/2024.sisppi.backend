<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
