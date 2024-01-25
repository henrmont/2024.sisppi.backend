<?php

namespace App\Http\Controllers;

use App\Models\ExerciseYear;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseYearController extends Controller
{
    public function getExerciseYears(): JsonResponse {

        $exercise_years = ExerciseYear::where('deleted_at',null)->orderBy('id', 'asc')->get(['id','name','is_valid']);

        return response()->json([
            "data" => $exercise_years
        ]);

    }

    public function getValidExerciseYears(): JsonResponse {

        $exercise_years = ExerciseYear::where('deleted_at',null)->where('is_valid',true)->orderBy('id', 'asc')->get(['id','name','is_valid']);

        return response()->json([
            "data" => $exercise_years
        ]);

    }

    public function getWalletExerciseYears(): JsonResponse {

        $data = [];
        $exercise_years = ExerciseYear::with(['ministerial_ordinaces.ministerial_ordinace_destinations','incentives.incentive_destinations'])->where('deleted_at',null)->where('is_valid',true)->orderBy('id', 'asc')->get();

        foreach ($exercise_years as $chv => $vlr) {
            array_push($data, ["name" => $vlr->name, "data" => [], "total" => 0]);
            foreach ($vlr->ministerial_ordinaces as $item) {
                foreach ($item->ministerial_ordinace_destinations as $res) {
                    if ($res->county_id == auth()->user()->county_id) {
                        $ministerial_ordinace_item = [
                            "id" => $item->id,
                            "date" => $item->date,
                            "type" => $item->type,
                            "name" => $item->name,
                            "title" => 'Portaria ministerial',
                            "value" => $res->value,
                            "hasFile" => $item->file ? false : true
                        ];
                        array_push($data[$chv]["data"], $ministerial_ordinace_item);
                        if ($item->type == 'acrescimo') {
                            $data[$chv]["total"] += $res->value;
                        } else {
                            $data[$chv]["total"] -= $res->value;
                        }
                    }
                }
            }

            foreach ($vlr->incentives as $item) {
                foreach ($item->incentive_destinations as $res) {
                    if ($res->county_id == auth()->user()->county_id) {
                        $incentive_item = [
                            "id" => $item->id,
                            "date" => $item->date,
                            "type" => $item->type,
                            "name" => $item->name,
                            "title" => 'Incentivo',
                            "value" => $res->value,
                            "hasFile" => $item->file ? false : true
                        ];
                        array_push($data[$chv]["data"], $incentive_item);
                        if ($item->type == 'acrescimo') {
                            $data[$chv]["total"] += $res->value;
                        } else {
                            $data[$chv]["total"] -= $res->value;
                        }
                    }
                }
            }
        }

        return response()->json([
            "data" => $data,
        ]);

    }

    public function createExerciseYear(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $exercise_year = ExerciseYear::create([
                'name'  => $request->name,
            ]);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Inclusão do ano de exercício',
                'content'   => 'O ano de exercício '.$exercise_year->name.' foi criado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Ano de exercício criado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function updateExerciseYear(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $exercise_year = ExerciseYear::find($request->id);
            $exercise_year->name = $request->name;
            $exercise_year->updated_at = now();
            $exercise_year->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Atualização do ano de exercício',
                'content'   => 'O ano de exercício '.$exercise_year->name.' foi atualizado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Ano de exercício atualizado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function deleteExerciseYear($id): JsonResponse {
        try {
            DB::beginTransaction();

            $exercise_year = ExerciseYear::find($id);
            $exercise_year->is_valid = false;
            $exercise_year->deleted_at = now();
            $exercise_year->updated_at = now();
            $exercise_year->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Exclusão do ano de exercício',
                'content'   => 'O ano de exercício '.$exercise_year->name.' foi excluído com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Ano de exercício excluído com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function validateExerciseYear($id): JsonResponse {
        try {
            DB::beginTransaction();

            $exercise_year = ExerciseYear::find($id);
            $exercise_year->is_valid = !$exercise_year->is_valid;
            $exercise_year->updated_at = now();
            $exercise_year->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Validação do ano de exercício',
                'content'   => 'O ano de exercício '.$exercise_year->name.' foi validado/invalidado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Ano de exercício validado/invalidado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
