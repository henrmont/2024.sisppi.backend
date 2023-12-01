<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function create(Request $request) {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

    }

    public function getAccount($email): JsonResponse {

        $user = User::where('email', $email)->get();

        return response()->json([
            "data" => $user
        ]);

    }
}
