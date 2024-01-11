<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function getFavorites($id): JsonResponse
    {
        $favorites = Favorite::where('user_id',$id)->with(['link'])->get();

        return response()->json(['data' => $favorites]);
    }

    public function createFavorite(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $favorite = Favorite::create([
                'link_id' => $request->link_id,
                'user_id' => $request->user_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Link adicionado aos favoritos.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }

    }
}
