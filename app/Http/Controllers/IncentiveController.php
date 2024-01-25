<?php

namespace App\Http\Controllers;

use App\Models\Incentive;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncentiveController extends Controller
{
    public function getIncentives(): JsonResponse {

        $incentives = Incentive::with(['competence','exercise_year'])
            ->whereHas('exercise_year', function($q) {
                $q->where('is_valid',true);
            })
            ->whereHas('competence', function($q) {
                $q->where('is_valid',true);
            })
            ->where('deleted_at',null)->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $incentives
        ]);

    }

    public function getIncentive($id): JsonResponse {

        $incentive = Incentive::find($id);

        return response()->json([
            "data" => $incentive
        ]);

    }

    public function createIncentive(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $incentive = Incentive::create([
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
                'title' => 'Inclusão de incentivo',
                'content'   => 'O incentivo '.$incentive->name.' foi criado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Incentivo criado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function updateIncentive(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $incentive = Incentive::find($request->id);
            $incentive->number = $request->number;
            $incentive->name = $request->name;
            $incentive->date = $request->date;
            $incentive->value = $request->value;
            $incentive->type = $request->type;
            $incentive->observation = $request->observation;
            $incentive->exercise_year_id = $request->exercise_year_id;
            $incentive->competence_id = $request->competence_id;
            $incentive->updated_at = now();
            $incentive->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Atualização do incentivo',
                'content'   => 'O incentivo '.$incentive->name.' foi atualizado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Incentivo atualizado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function deleteIncentive($id): JsonResponse {
        try {
            DB::beginTransaction();

            $incentive = Incentive::find($id);
            $incentive->is_valid = false;
            $incentive->deleted_at = now();
            $incentive->updated_at = now();
            $incentive->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Exclusão do incentivo',
                'content'   => 'O incentivo '.$incentive->name.' foi excluído com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Incentivo excluído com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function validateIncentive($id): JsonResponse {
        try {
            DB::beginTransaction();

            $incentive = Incentive::find($id);
            $incentive->is_valid = !$incentive->is_valid;
            $incentive->updated_at = now();
            $incentive->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Validação do incentivo',
                'content'   => 'O incentivo '.$incentive->name.' foi validado/invalidado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Incentivo validado/invalidado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function attachIncentive(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $incentive = Incentive::find($request->id);
            $incentive->file = $request->file;
            $incentive->updated_at = now();
            $incentive->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Arquivo do incentivo',
                'content'   => 'O arquivo do incentivo '.$incentive->name.' foi anexado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Arquivo do incentivo anexado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
