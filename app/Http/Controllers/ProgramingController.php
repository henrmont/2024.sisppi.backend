<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Programing;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramingController extends Controller
{
    public function getProgramings(): JsonResponse {

        $user = User::with(['roles'])->find(auth()->user()->id);
        if ($user->roles) {
            $is_admin = false;
            foreach ($user->roles as $vlr) {
                if ($vlr->name == 'admin') {
                    $programings = Programing::with(['county','exercise_year','procedures.procedure'])->whereHas('exercise_year', function($q) {
                        $q->where('is_valid',true);
                    })->where('deleted_at',null)->orderBy('id', 'asc')->get();
                    $is_admin = true;
                }
            }
            if (!$is_admin) {
                $programings = Programing::with(['county','exercise_year','procedures.procedure'])->whereHas('exercise_year', function($q) {
                    $q->where('is_valid',true);
                })->where('county_id',auth()->user()->county_id)->where('deleted_at',null)->orderBy('id', 'asc')->get();
            }
        } else {
            $programings = Programing::with(['county','exercise_year','procedures.procedure'])->whereHas('exercise_year', function($q) {
                $q->where('is_valid',true);
            })->where('county_id',auth()->user()->county_id)->where('deleted_at',null)->orderBy('id', 'asc')->get();
        }

        return response()->json([
            "data" => $programings
        ]);

    }

    public function createPrograming(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $programing = Programing::create([
                'name'  => $request->programing_name,
                'exercise_year_id' => $request->exercise_year_id,
                'county_id'  => auth()->user()->county_id,
            ]);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Inclusão da programação',
                'content'   => 'A programação '.$programing->name.' foi criada com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Programação criada com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function updatePrograming(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $programing = Programing::find($request->id);
            $programing->name = $request->name;
            $programing->updated_at = now();
            $programing->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Atualização da programação',
                'content'   => 'A programação '.$programing->name.' foi atualizada com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Programação atualizada com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function deletePrograming($id): JsonResponse {
        try {
            DB::beginTransaction();

            $programing = Programing::find($id);
            $programing->is_valid = false;
            $programing->deleted_at = now();
            $programing->updated_at = now();
            $programing->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Exclusão da programação',
                'content'   => 'A programação '.$programing->name.' foi excluída com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Programação excluída com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function validatePrograming($id): JsonResponse {
        try {
            DB::beginTransaction();

            $programing = Programing::find($id);
            $programing->is_valid = !$programing->is_valid;
            $programing->updated_at = now();
            $programing->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Validação da programação',
                'content'   => 'A programação '.$programing->name.' foi validada/invalidada com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Programação validada/invalidada com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
