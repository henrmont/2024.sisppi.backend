<?php

namespace App\Http\Controllers;

use App\Models\Subgroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubgroupController extends Controller
{
    public function getSubgroups(): JsonResponse {

        $subgroups = Subgroup::with(['competence'])->whereHas('competence', function($q) {
            $q->where('is_valid', true);
        })->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $subgroups
        ]);

    }
}
