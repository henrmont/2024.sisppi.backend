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
    public function getFavorites(): JsonResponse
    {
        $favorites = Favorite::where('user_id',auth()->user()->id)->with(['link'])->withCount(['link'])->get();

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

    public function checkFavorite($id): JsonResponse
    {
        $favorite = Favorite::where('user_id',auth()->user()->id)->where('link_id',$id)->get();

        return response()->json(['data' => $favorite]);
    }

    public function addFavorite($id): JsonResponse {
        try {
            DB::beginTransaction();

            $favorite = Favorite::create([
                'user_id'  => auth()->user()->id,
                'link_id'  => $id
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Página adicionada aos favoritos.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function removeFavorite($id): JsonResponse {
        try {
            DB::beginTransaction();

            $favorite = Favorite::where('user_id',auth()->user()->id)->where('link_id',$id)->delete();

            DB::commit();

            return response()->json([
                "message" => 'Página removida dos favoritos.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
