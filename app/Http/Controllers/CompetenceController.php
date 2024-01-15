<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompetenceController extends Controller
{
    public function getCompetencies(): JsonResponse {

        $competencies = Competence::where('deleted_at',null)->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $competencies
        ]);

    }

    public function deleteCompetence($id): JsonResponse {
        try {
            DB::beginTransaction();

            $competence = Competence::find($id);
            $competence->is_valid = false;
            $competence->deleted_at = now();
            $competence->updated_at = now();
            $competence->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Exclusão da competência',
                'content'   => 'A competência '.$competence->competence.' foi excluída com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Competência excluída com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function validateCompetence($id): JsonResponse {
        try {
            DB::beginTransaction();

            $competence = Competence::find($id);
            $competence->is_valid = !$competence->is_valid;
            $competence->updated_at = now();
            $competence->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Validação da competência',
                'content'   => 'A competência '.$competence->competence.' foi validada/invalidada com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Competência validada/invalidada com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
