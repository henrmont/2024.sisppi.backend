<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function getGroups(): JsonResponse {

        $groups = Group::with(['competence'])->whereHas('competence', function($q) {
            $q->where('is_valid', true);
        })->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $groups
        ]);

    }
}
