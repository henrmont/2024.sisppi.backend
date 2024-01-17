<?php

namespace App\Http\Controllers;

use App\Models\Modality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModalityController extends Controller
{
    public function getModalities(): JsonResponse {

        $modalities = Modality::with(['competence'])->whereHas('competence', function($q) {
            $q->where('is_valid', true);
        })->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $modalities
        ]);

    }
}
