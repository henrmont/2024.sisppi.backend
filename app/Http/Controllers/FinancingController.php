<?php

namespace App\Http\Controllers;

use App\Models\Financing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinancingController extends Controller
{
    public function getFinancings(): JsonResponse {

        $financings = Financing::with(['competence'])->whereHas('competence', function($q) {
            $q->where('is_valid', true);
        })->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $financings
        ]);

    }
}
