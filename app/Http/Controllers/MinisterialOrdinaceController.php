<?php

namespace App\Http\Controllers;

use App\Models\MinisterialOrdinace;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MinisterialOrdinaceController extends Controller
{
    public function getMinisterialOrdinaces(): JsonResponse {

        $ministerial_ordinaces = MinisterialOrdinace::with(['competence','exercise_year'])
            ->whereHas('exercise_year', function($q) {
                $q->where('is_valid',true);
            })
            ->whereHas('competence', function($q) {
                $q->where('is_valid',true);
            })
            ->where('deleted_at',null)->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $ministerial_ordinaces
        ]);

    }

    public function createMinisterialOrdinace(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $ministerial_ordinace = MinisterialOrdinace::create([
                'number'  => $request->number,
                'name'  => $request->name,
                'date'    => $request->date,
                'value'  => $request->value,
                'type'    => $request->type,
                'observation' => $request->observation,
                'exercise_year_id'    => $request->exercise_year_id,
                'competence_id'   => $request->competence_id,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Inclusão de portaria ministerial',
                'content'   => 'A portaria ministerial '.$ministerial_ordinace->name.' foi criada com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Portaria ministerial criado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function updateMinisterialOrdinace(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $ministerial_ordinace = MinisterialOrdinace::find($request->id);
            $ministerial_ordinace->number = $request->number;
            $ministerial_ordinace->name = $request->name;
            $ministerial_ordinace->date = $request->date;
            $ministerial_ordinace->value = $request->value;
            $ministerial_ordinace->type = $request->type;
            $ministerial_ordinace->observation = $request->observation;
            $ministerial_ordinace->exercise_year_id = $request->exercise_year_id;
            $ministerial_ordinace->competence_id = $request->competence_id;
            $ministerial_ordinace->updated_at = now();
            $ministerial_ordinace->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Atualização da portaria ministerial',
                'content'   => 'A portaria ministerial '.$ministerial_ordinace->name.' foi atualizada com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Portaria ministerial atualizada com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function deleteMinisterialOrdinace($id): JsonResponse {
        try {
            DB::beginTransaction();

            $ministerial_ordinace = MinisterialOrdinace::find($id);
            $ministerial_ordinace->is_valid = false;
            $ministerial_ordinace->deleted_at = now();
            $ministerial_ordinace->updated_at = now();
            $ministerial_ordinace->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Exclusão da portaria ministerial',
                'content'   => 'A portaria ministerial '.$ministerial_ordinace->name.' foi excluída com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Portaria ministerial excluída com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function validateMinisterialOrdinace($id): JsonResponse {
        try {
            DB::beginTransaction();

            $ministerial_ordinace = MinisterialOrdinace::find($id);
            $ministerial_ordinace->is_valid = !$ministerial_ordinace->is_valid;
            $ministerial_ordinace->updated_at = now();
            $ministerial_ordinace->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Validação da portaria ministerial',
                'content'   => 'A portaria ministerial '.$ministerial_ordinace->name.' foi validada/invalidada com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Portaria ministerial validada/invalidada com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function attachMinisterialOrdinace(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $ministerial_ordinace = MinisterialOrdinace::find($request->id);
            $ministerial_ordinace->file = $request->file;
            $ministerial_ordinace->updated_at = now();
            $ministerial_ordinace->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Arquivo da portaria ministerial',
                'content'   => 'O arquivo da portaria ministerial '.$ministerial_ordinace->name.' foi anexado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Arquivo da portaria ministerial anexado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
