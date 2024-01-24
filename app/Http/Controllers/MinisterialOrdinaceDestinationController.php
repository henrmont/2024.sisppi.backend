<?php

namespace App\Http\Controllers;

use App\Models\MinisterialOrdinaceDestination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MinisterialOrdinaceDestinationController extends Controller
{
    public function getMinisterialOrdinaceDestinations($id): JsonResponse {

        $ministerial_ordinace_destinations = MinisterialOrdinaceDestination::with(['ministerial_ordinace','county'])->where('ministerial_ordinace_id',$id)->orderBy('id','asc')->get();

        return response()->json([
            "data" => $ministerial_ordinace_destinations
        ]);

    }

    public function addMinisterialOrdinaceDestination(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $ministerial_ordinace_destination = MinisterialOrdinaceDestination::create([
                'ministerial_ordinace_id'  => $request->ministerial_ordinace_id,
                'county_id' => $request->county_id,
                'value' => $request->value,
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Destino adicionado à portaria ministerial'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function valueMinisterialOrdinaceDestination(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $ministerial_ordinace_destination = MinisterialOrdinaceDestination::find($request->id);
            $ministerial_ordinace_destination->value = $request->value;
            $ministerial_ordinace_destination->updated_at = now();
            $ministerial_ordinace_destination->save();

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

    public function removeMinisterialOrdinaceDestination($id): JsonResponse {
        try {
            DB::beginTransaction();

            $ministerial_ordinace_destination = MinisterialOrdinaceDestination::find($id);
            $ministerial_ordinace_destination->delete();

            DB::commit();

            return response()->json([
                "message" => 'Destino removido da portaria ministerial'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }
}
