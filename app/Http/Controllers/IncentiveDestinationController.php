<?php

namespace App\Http\Controllers;

use App\Models\IncentiveDestination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncentiveDestinationController extends Controller
{
    public function getIncentiveDestinations($id): JsonResponse {

        $incentive_destinations = IncentiveDestination::with(['incentive','county'])->where('incentive_id',$id)->orderBy('id','asc')->get();

        return response()->json([
            "data" => $incentive_destinations
        ]);

    }

    public function addIncentiveDestination(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $incentive_destination = IncentiveDestination::create([
                'incentive_id'  => $request->incentive_id,
                'county_id' => $request->county_id,
                'value' => $request->value,
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Destino adicionado ao incentivo'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function valueIncentiveDestination(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $incentive_destination = IncentiveDestination::find($request->id);
            $incentive_destination->value = $request->value;
            $incentive_destination->updated_at = now();
            $incentive_destination->save();

            DB::commit();

            return response()->json([
                "message" => 'Valor do destino alterado'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function removeIncentiveDestination($id): JsonResponse {
        try {
            DB::beginTransaction();

            $incentive_destination = IncentiveDestination::find($id);
            $incentive_destination->delete();

            DB::commit();

            return response()->json([
                "message" => 'Destino removido do incentivo'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
