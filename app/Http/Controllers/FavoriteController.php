<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function getFavorites($id): JsonResponse
    {
        $favorites = Favorite::where('user_id',$id)->with(['link'])->get();

        return response()->json(['data' => $favorites]);
    }

    public function createFavorite(Request $request) {

        $favorite = Favorite::create([
            'link_id' => $request->link_id,
            'user_id' => $request->user_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
