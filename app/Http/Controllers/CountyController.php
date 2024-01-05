<?php

namespace App\Http\Controllers;

use App\Models\County;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountyController extends Controller
{
    public function getCounties(): JsonResponse {

        $counties = County::orderBy('id', 'asc')->withCount(['users'])->get();

        return response()->json([
            "data" => $counties
        ]);

    }

    public function getCounty($id): JsonResponse {

        $county = County::with(['users'])->find($id);

        return response()->json([
            "data" => $county
        ]);

    }
}
