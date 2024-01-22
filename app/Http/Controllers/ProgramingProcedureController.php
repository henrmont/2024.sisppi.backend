<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\ProgramingProcedure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramingProcedureController extends Controller
{
    public function getProgramingProcedures($id): JsonResponse {

        $procedures = ProgramingProcedure::with(['procedure.competence'])->where('programing_id',$id)->orderBy('id','asc')->get();

        return response()->json([
            "data" => $procedures
        ]);

    }

    public function addProgramingProcedure(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $procedure = ProgramingProcedure::create([
                'programing_id'  => $request->programing_id,
                'procedure_id' => $request->procedure_id,
                'amount' => $request->amount,
                'type' => $request->type,
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Procedimento adicionado à programação'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function amountProgramingProcedure(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $procedure = ProgramingProcedure::find($request->id);
            $procedure->amount = $request->amount;
            $procedure->updated_at = now();
            $procedure->save();

            DB::commit();

            return response()->json([
                "message" => 'Quantidade alterada'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function typeProgramingProcedure(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $procedure = ProgramingProcedure::find($request->id);
            $procedure->type = $request->type;
            $procedure->updated_at = now();
            $procedure->save();

            DB::commit();

            return response()->json([
                "message" => 'Tipo alterado'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function removeProgramingProcedure($id): JsonResponse {
        try {
            DB::beginTransaction();

            $procedure = ProgramingProcedure::find($id);
            $procedure->delete();

            DB::commit();

            return response()->json([
                "message" => 'Procedimento removido'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
